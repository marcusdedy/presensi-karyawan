<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'tipe', 'tanggal', 'jam_rencana', 'jam_normal',
        'durasi_menit', 'alasan', 'lampiran', 'status', 'approved_by', 'catatan_approval',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }

    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'terlambat' => 'Izin Terlambat',
            'pulang_cepat' => 'Izin Pulang Cepat',
            default => '-',
        };
    }
}
