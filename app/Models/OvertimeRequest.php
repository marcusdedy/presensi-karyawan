<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OvertimeRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'tanggal', 'jam_mulai', 'jam_selesai',
        'durasi_menit', 'alasan', 'tipe_hari', 'status', 'approved_by', 'catatan_approval',
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

    public function getDurasiFormattedAttribute(): string
    {
        $jam = intdiv($this->durasi_menit, 60);
        $menit = $this->durasi_menit % 60;
        return $jam > 0 ? "{$jam} jam {$menit} menit" : "{$menit} menit";
    }
}
