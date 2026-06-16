<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerHistory;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Position;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'position']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                    ->orWhere('nik', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderBy('nik')->paginate(15);
        $departments = Department::where('is_active', true)->get();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        $shifts = WorkShift::where('is_active', true)->get();

        return view('admin.employees.create', compact('departments', 'positions', 'shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees',
            'pin' => 'required|string|min:4|max:8',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'work_shift_id' => 'nullable|exists:work_shifts,id',
        ]);

        $data = $request->except('pin');
        $data['pin'] = Hash::make($request->pin);

        $employee = Employee::create($data);

        // Create leave balance
        $cutiTahunan = LeaveType::where('nama', 'Cuti Tahunan')->first();
        if ($cutiTahunan) {
            LeaveBalance::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $cutiTahunan->id,
                'tahun' => now()->year,
                'jatah' => $cutiTahunan->jatah_hari,
                'terpakai' => 0,
                'sisa' => $cutiTahunan->jatah_hari,
            ]);
        }

        // Create career history - entry
        CareerHistory::create([
            'employee_id' => $employee->id,
            'tipe' => 'perubahan_status',
            'tanggal_efektif' => $request->tanggal_masuk,
            'jabatan_baru' => $employee->position?->nama,
            'departemen_baru' => $employee->department?->nama,
            'status_baru' => $employee->status_karyawan,
            'catatan' => 'Masuk kerja',
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('is_active', true)->get();
        $positions = Position::where('is_active', true)->get();
        $shifts = WorkShift::where('is_active', true)->get();

        return view('admin.employees.edit', compact('employee', 'departments', 'positions', 'shifts'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nik' => 'required|string|unique:employees,nik,' . $employee->id,
            'nama_lengkap' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'work_shift_id' => 'nullable|exists:work_shifts,id',
        ]);

        $data = $request->except('pin');

        if ($request->filled('pin')) {
            $data['pin'] = Hash::make($request->pin);
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->update(['status' => 'nonaktif', 'tanggal_keluar' => now()]);
        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil dinonaktifkan.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'workShift', 'careerHistories' => function ($q) {
            $q->orderBy('tanggal_efektif', 'desc');
        }]);

        return view('admin.employees.show', compact('employee'));
    }
}
