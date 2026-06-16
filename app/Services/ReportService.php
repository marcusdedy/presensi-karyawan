<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\OvertimeRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDashboardStats(): array
    {
        $today = now()->toDateString();
        $totalKaryawan = Employee::where('status', 'aktif')->count();

        $attendanceToday = Attendance::where('tanggal', $today);

        return [
            'total_karyawan' => $totalKaryawan,
            'hadir_hari_ini' => (clone $attendanceToday)->whereIn('status', ['hadir', 'terlambat', 'terlambat_izin'])->count(),
            'terlambat_hari_ini' => (clone $attendanceToday)->whereIn('status', ['terlambat', 'terlambat_izin'])->count(),
            'cuti_hari_ini' => LeaveRequest::where('status', 'disetujui')
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->count(),
            'alpha_hari_ini' => $totalKaryawan - (clone $attendanceToday)->count() - LeaveRequest::where('status', 'disetujui')
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->count(),
        ];
    }

    public function getMonthlyAttendanceStats(int $bulan = null, int $tahun = null): array
    {
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        $stats = Attendance::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return $stats;
    }

    public function getOvertimeStats(int $bulan = null, int $tahun = null): array
    {
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        $totalMenit = OvertimeRequest::where('status', 'disetujui')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('durasi_menit');

        $hariKerja = OvertimeRequest::where('status', 'disetujui')
            ->where('tipe_hari', 'kerja')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('durasi_menit');

        $hariLibur = OvertimeRequest::where('status', 'disetujui')
            ->whereIn('tipe_hari', ['libur', 'weekend'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('durasi_menit');

        return [
            'total_menit' => $totalMenit,
            'total_jam' => round($totalMenit / 60, 1),
            'hari_kerja_menit' => $hariKerja,
            'hari_libur_menit' => $hariLibur,
        ];
    }

    public function getPendingApprovals(): array
    {
        return [
            'cuti' => LeaveRequest::where('status', 'pending')->count(),
            'izin' => \App\Models\PermissionRequest::where('status', 'pending')->count(),
            'lembur' => OvertimeRequest::where('status', 'pending')->count(),
        ];
    }

    public function getAttendanceByDepartment(int $bulan = null, int $tahun = null): array
    {
        $bulan = $bulan ?? now()->month;
        $tahun = $tahun ?? now()->year;

        return Employee::select('departments.nama as departemen')
            ->selectRaw('COUNT(DISTINCT employees.id) as total_karyawan')
            ->selectRaw("COUNT(CASE WHEN attendances.status = 'hadir' THEN 1 END) as total_hadir")
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('attendances', function ($join) use ($bulan, $tahun) {
                $join->on('employees.id', '=', 'attendances.employee_id')
                    ->whereMonth('attendances.tanggal', $bulan)
                    ->whereYear('attendances.tanggal', $tahun);
            })
            ->where('employees.status', 'aktif')
            ->groupBy('departments.nama')
            ->get()
            ->toArray();
    }
}
