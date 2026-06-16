<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'tanggal', 'jam_masuk', 'jam_keluar',
        'shift_id', 'status', 'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift()
    {
        return $this->belongsTo(WorkShift::class, 'shift_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'success',
            'terlambat' => 'danger',
            'terlambat_izin' => 'warning',
            'pulang_cepat' => 'danger',
            'pulang_cepat_izin' => 'warning',
            'cuti' => 'info',
            'libur' => 'secondary',
            'alpha' => 'dark',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'terlambat_izin' => 'Terlambat (Izin)',
            'pulang_cepat' => 'Pulang Cepat',
            'pulang_cepat_izin' => 'Pulang Cepat (Izin)',
            'cuti' => 'Cuti',
            'libur' => 'Libur',
            'alpha' => 'Alpha',
            default => '-',
        };
    }
}
