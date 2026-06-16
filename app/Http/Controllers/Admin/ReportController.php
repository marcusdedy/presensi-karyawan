<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\OvertimeRequest;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function attendance(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $departmentId = $request->get('department_id');

        $query = Employee::with(['attendances' => function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }, 'department'])->where('status', 'aktif');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $employees = $query->orderBy('nik')->get();
        $departments = Department::where('is_active', true)->get();

        return view('admin.reports.attendance', compact('employees', 'bulan', 'tahun', 'departments', 'departmentId'));
    }

    public function leave(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);

        $balances = LeaveBalance::with(['employee.department', 'leaveType'])
            ->where('tahun', $tahun)
            ->whereHas('employee', function ($q) {
                $q->where('status', 'aktif');
            })
            ->get()
            ->groupBy('employee_id');

        return view('admin.reports.leave', compact('balances', 'tahun'));
    }

    public function overtime(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);

        $overtimes = OvertimeRequest::with(['employee.department'])
            ->where('status', 'disetujui')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('employee_id');

        $departments = Department::where('is_active', true)->get();

        return view('admin.reports.overtime', compact('overtimes', 'bulan', 'tahun', 'departments'));
    }
}
