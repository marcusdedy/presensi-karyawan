<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\WorkShift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = WorkShift::all();
        return view('admin.shifts.index', compact('shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'toleransi_terlambat_menit' => 'required|integer|min:0',
        ]);

        WorkShift::create($request->only(['nama', 'jam_masuk', 'jam_keluar', 'toleransi_terlambat_menit']));
        return redirect()->route('admin.shifts.index')->with('success', 'Shift berhasil ditambahkan.');
    }

    public function update(Request $request, WorkShift $shift)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i',
            'toleransi_terlambat_menit' => 'required|integer|min:0',
        ]);

        $shift->update($request->only(['nama', 'jam_masuk', 'jam_keluar', 'toleransi_terlambat_menit']));
        return redirect()->route('admin.shifts.index')->with('success', 'Shift berhasil diperbarui.');
    }

    public function destroy(WorkShift $shift)
    {
        $shift->update(['is_active' => false]);
        return redirect()->route('admin.shifts.index')->with('success', 'Shift berhasil dinonaktifkan.');
    }

    // Employee Shift Schedule
    public function schedule(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai', now()->startOfWeek()->toDateString());
        $tanggalSelesai = $request->get('tanggal_selesai', now()->endOfWeek()->toDateString());
        $departmentId = $request->get('department_id');

        $query = Employee::with(['employeeShifts' => function ($q) use ($tanggalMulai, $tanggalSelesai) {
            $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->with('workShift');
        }])->where('status', 'aktif');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $employees = $query->get();
        $shifts = WorkShift::where('is_active', true)->get();

        return view('admin.shifts.schedule', compact('employees', 'shifts', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function scheduleStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_shift_id' => 'required|exists:work_shifts,id',
            'tanggal' => 'required|date',
        ]);

        EmployeeShift::updateOrCreate(
            ['employee_id' => $request->employee_id, 'tanggal' => $request->tanggal],
            ['work_shift_id' => $request->work_shift_id]
        );

        return redirect()->back()->with('success', 'Jadwal shift berhasil disimpan.');
    }
}
