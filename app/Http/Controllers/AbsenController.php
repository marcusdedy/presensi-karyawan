<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Services\AttendanceService;
use App\Services\MotivationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AbsenController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService,
        private MotivationService $motivationService,
    ) {}

    public function index()
    {
        return view('absen.index');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'pin' => 'required|string|min:4|max:8',
        ]);

        // Cari karyawan berdasarkan NIK
        $employee = Employee::where('nik', $request->nik)
            ->where('status', 'aktif')
            ->first();

        if (!$employee) {
            return back()->with('error', 'NIK tidak ditemukan.')->withInput(['nik' => $request->nik]);
        }

        // Verifikasi PIN
        if (!Hash::check($request->pin, $employee->pin)) {
            return back()->with('error', 'PIN salah. Silakan coba lagi.')->withInput(['nik' => $request->nik]);
        }

        // Check if already has today's attendance
        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        $canAbsenMasuk = !$todayAttendance || !$todayAttendance->jam_masuk;
        $canAbsenPulang = $todayAttendance && $todayAttendance->jam_masuk && !$todayAttendance->jam_keluar;

        return view('absen.confirm', compact('employee', 'canAbsenMasuk', 'canAbsenPulang', 'todayAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tipe' => 'required|in:masuk,pulang',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        if ($request->tipe === 'masuk') {
            $result = $this->attendanceService->prosesAbsenMasuk($employee);
        } else {
            $result = $this->attendanceService->prosesAbsenPulang($employee);
        }

        if (!$result['success']) {
            return redirect()->route('absen.index')->with('error', $result['message']);
        }

        $motivation = $this->motivationService->getMotivation($request->tipe);

        return view('absen.success', [
            'employee' => $employee,
            'tipe' => $request->tipe,
            'motivation' => $motivation,
            'attendance' => $result['attendance'],
        ]);
    }
}
