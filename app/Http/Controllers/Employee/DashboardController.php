<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveType;

class DashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::with(['department', 'position'])->find(session('employee_id'));

        $todayAttendance = Attendance::where('employee_id', $employee->id)
            ->where('tanggal', now()->toDateString())
            ->first();

        $cutiTahunan = LeaveType::where('nama', 'Cuti Tahunan')->first();
        $sisaCuti = 0;
        if ($cutiTahunan) {
            $balance = LeaveBalance::where('employee_id', $employee->id)
                ->where('leave_type_id', $cutiTahunan->id)
                ->where('tahun', now()->year)
                ->first();
            $sisaCuti = $balance ? $balance->sisa : 0;
        }

        $attendanceThisMonth = Attendance::where('employee_id', $employee->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $stats = [
            'hadir' => $attendanceThisMonth->whereIn('status', ['hadir'])->count(),
            'terlambat' => $attendanceThisMonth->whereIn('status', ['terlambat', 'terlambat_izin'])->count(),
            'alpha' => $attendanceThisMonth->where('status', 'alpha')->count(),
        ];

        return view('employee.dashboard', compact('employee', 'todayAttendance', 'sisaCuti', 'stats'));
    }
}
