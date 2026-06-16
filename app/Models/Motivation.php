<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivation extends Model
{
    use HasFactory;

    protected $fillable = ['tipe', 'kategori', 'pesan', 'gif_url', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    public function scopePulang($query)
    {
        return $query->where('tipe', 'pulang');
    }
}
