<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'tipe', 'tanggal_efektif',
        'jabatan_lama', 'jabatan_baru', 'departemen_lama', 'departemen_baru',
        'lokasi_lama', 'lokasi_baru', 'status_lama', 'status_baru',
        'no_sk', 'file_sk', 'catatan',
    ];

    protected $casts = [
        'tanggal_efektif' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'promosi' => 'Promosi',
            'demosi' => 'Demosi',
            'mutasi' => 'Mutasi',
            'rotasi' => 'Rotasi',
            'perubahan_status' => 'Perubahan Status',
            default => '-',
        };
    }

    public function getTipeIconAttribute(): string
    {
        return match($this->tipe) {
            'promosi' => 'bi-arrow-up-circle-fill text-success',
            'demosi' => 'bi-arrow-down-circle-fill text-danger',
            'mutasi' => 'bi-arrow-left-right text-primary',
            'rotasi' => 'bi-arrow-repeat text-info',
            'perubahan_status' => 'bi-pencil-square text-warning',
            default => 'bi-circle',
        };
    }
}
