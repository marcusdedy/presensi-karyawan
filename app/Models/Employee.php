<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nik', 'pin', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'status_pernikahan', 'no_ktp',
        'no_hp', 'email', 'alamat_ktp', 'alamat_domisili', 'foto',
        'department_id', 'position_id', 'work_shift_id', 'atasan_id',
        'tanggal_masuk', 'tanggal_keluar', 'status_karyawan', 'status',
        'nama_kontak_darurat', 'hubungan_kontak_darurat', 'no_hp_kontak_darurat',
    ];

    protected $hidden = ['pin'];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function workShift()
    {
        return $this->belongsTo(WorkShift::class, 'work_shift_id');
    }

    public function atasan()
    {
        return $this->belongsTo(Employee::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(Employee::class, 'atasan_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function permissionRequests()
    {
        return $this->hasMany(PermissionRequest::class);
    }

    public function overtimeRequests()
    {
        return $this->hasMany(OvertimeRequest::class);
    }

    public function careerHistories()
    {
        return $this->hasMany(CareerHistory::class);
    }

    public function employeeShifts()
    {
        return $this->hasMany(EmployeeShift::class);
    }

    public function getShiftForDate($date = null)
    {
        $date = $date ?? now()->toDateString();
        
        $employeeShift = $this->employeeShifts()
            ->where('tanggal', $date)
            ->with('workShift')
            ->first();

        if ($employeeShift) {
            return $employeeShift->workShift;
        }

        return $this->workShift;
    }
}
