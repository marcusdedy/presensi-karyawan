<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShift extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jam_masuk', 'jam_keluar', 'toleransi_terlambat_menit', 'is_active'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'work_shift_id');
    }

    public function employeeShifts()
    {
        return $this->hasMany(EmployeeShift::class, 'work_shift_id');
    }
}
