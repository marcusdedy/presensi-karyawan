<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\CareerHistory;
use App\Models\Employee;

class ProfileController extends Controller
{
    public function index()
    {
        $employee = Employee::with(['department', 'position', 'workShift'])->find(session('employee_id'));
        return view('employee.profile.index', compact('employee'));
    }

    public function career()
    {
        $histories = CareerHistory::where('employee_id', session('employee_id'))
            ->orderBy('tanggal_efektif', 'desc')
            ->get();

        $employee = Employee::find(session('employee_id'));

        return view('employee.profile.career', compact('histories', 'employee'));
    }
}
