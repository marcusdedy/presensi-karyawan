<?php

namespace App\Services;

use App\Models\Motivation;

class MotivationService
{
    public function getMotivation(string $tipe): ?Motivation
    {
        $kategori = $this->getKategori($tipe);

        $motivation = Motivation::where('tipe', $tipe)
            ->where('is_active', true)
            ->where(function ($query) use ($kategori) {
                $query->where('kategori', $kategori)
                    ->orWhere('kategori', 'umum');
            })
            ->inRandomOrder()
            ->first();

        // Fallback ke umum
        if (!$motivation) {
            $motivation = Motivation::where('tipe', $tipe)
                ->where('kategori', 'umum')
                ->where('is_active', true)
                ->inRandomOrder()
                ->first();
        }

        return $motivation;
    }

    private function getKategori(string $tipe): string
    {
        $hari = now()->dayOfWeek;
        $jam = now()->hour;

        if ($tipe === 'masuk') {
            if ($hari === 1) return 'senin';
            if ($hari === 5) return 'jumat';
            if ($jam < 9) return 'pagi';
            if ($jam < 13) return 'siang';
            return 'umum';
        }

        if ($tipe === 'pulang') {
            if ($hari === 5) return 'jumat';
            if ($jam > 18) return 'lembur';
            return 'umum';
        }

        return 'umum';
    }
}
