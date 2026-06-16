<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->toDateString());

        $attendances = Attendance::with(['employee.department', 'employee.position'])
            ->where('tanggal', $tanggal)
            ->orderBy('jam_masuk')
            ->paginate(20);

        $departments = Department::where('is_active', true)->get();

        return view('admin.attendance.index', compact('attendances', 'tanggal', 'departments'));
    }

    public function monthly(Request $request)
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

        $employees = $query->orderBy('nik')->paginate(15);
        $departments = Department::where('is_active', true)->get();

        return view('admin.attendance.monthly', compact('employees', 'bulan', 'tahun', 'departments', 'departmentId'));
    }
}
