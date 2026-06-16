<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'nama', 'tipe', 'tahun', 'is_active'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeYear($query, $year)
    {
        return $query->where('tahun', $year);
    }
}
