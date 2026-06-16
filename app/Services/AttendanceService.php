<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\PermissionRequest;
use App\Models\Setting;
use Carbon\Carbon;

class AttendanceService
{
    public function prosesAbsenMasuk(Employee $employee): array
    {
        $now = now();
        $today = $now->toDateString();

        // Cek sudah absen hari ini
        $existing = Attendance::where('employee_id', $employee->id)
            ->where('tanggal', $today)
            ->first();

        if ($existing && $existing->jam_masuk) {
            return ['success' => false, 'message' => 'Anda sudah absen masuk hari ini.'];
        }

        // Get shift for today
        $shift = $employee->getShiftForDate($today);
        $jamMasukNormal = $shift ? $shift->jam_masuk : Setting::get('jam_masuk', '08:00');
        $toleransi = $shift ? $shift->toleransi_terlambat_menit : (int) Setting::get('toleransi_terlambat', 15);

        $batasJamMasuk = Carbon::parse($jamMasukNormal)->addMinutes($toleransi);
        $jamMasuk = $now->format('H:i:s');

        $status = 'hadir';
        $keterangan = null;

        // Cek terlambat
        if ($now->greaterThan($batasJamMasuk)) {
            // Cek izin terlambat
            $izinTerlambat = PermissionRequest::where('employee_id', $employee->id)
                ->where('tipe', 'terlambat')
                ->where('tanggal', $today)
                ->where('status', 'disetujui')
                ->first();

            if ($izinTerlambat) {
                if ($now->lessThanOrEqualTo(Carbon::parse($izinTerlambat->jam_rencana))) {
                    $status = 'terlambat_izin';
                    $keterangan = 'Terlambat dengan izin (disetujui)';
                } else {
                    $status = 'terlambat';
                    $keterangan = 'Melebihi batas izin terlambat';
                }
            } else {
                $status = 'terlambat';
                $keterangan = 'Terlambat tanpa izin';
            }
        }

        if ($existing) {
            $existing->update([
                'jam_masuk' => $jamMasuk,
                'shift_id' => $shift?->id,
                'status' => $status,
                'keterangan' => $keterangan,
            ]);
            $attendance = $existing;
        } else {
            $attendance = Attendance::create([
                'employee_id' => $employee->id,
                'tanggal' => $today,
                'jam_masuk' => $jamMasuk,
                'shift_id' => $shift?->id,
                'status' => $status,
                'keterangan' => $keterangan,
            ]);
        }

        return [
            'success' => true,
            'attendance' => $attendance,
            'status' => $status,
            'keterangan' => $keterangan,
            'tipe' => 'masuk',
        ];
    }

    public function prosesAbsenPulang(Employee $employee): array
    {
        $now = now();
        $today = $now->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->where('tanggal', $today)
            ->first();

        if (!$attendance || !$attendance->jam_masuk) {
            return ['success' => false, 'message' => 'Anda belum absen masuk hari ini.'];
        }

        if ($attendance->jam_keluar) {
            return ['success' => false, 'message' => 'Anda sudah absen pulang hari ini.'];
        }

        $shift = $employee->getShiftForDate($today);
        $jamKeluarNormal = $shift ? $shift->jam_keluar : Setting::get('jam_keluar', '17:00');
        $keterangan = $attendance->keterangan;

        // Cek pulang cepat
        if ($now->lessThan(Carbon::parse($jamKeluarNormal))) {
            $izinPulangCepat = PermissionRequest::where('employee_id', $employee->id)
                ->where('tipe', 'pulang_cepat')
                ->where('tanggal', $today)
                ->where('status', 'disetujui')
                ->first();

            if ($izinPulangCepat) {
                $keterangan = ($keterangan ? $keterangan . ' | ' : '') . 'Pulang cepat dengan izin';
                if ($attendance->status === 'hadir') {
                    $attendance->status = 'pulang_cepat_izin';
                }
            } else {
                $keterangan = ($keterangan ? $keterangan . ' | ' : '') . 'Pulang cepat tanpa izin';
                if ($attendance->status === 'hadir') {
                    $attendance->status = 'pulang_cepat';
                }
            }
        }

        $attendance->update([
            'jam_keluar' => $now->format('H:i:s'),
            'keterangan' => $keterangan,
            'status' => $attendance->status,
        ]);

        return [
            'success' => true,
            'attendance' => $attendance,
            'status' => $attendance->status,
            'keterangan' => $keterangan,
            'tipe' => 'pulang',
        ];
    }

    public function isHoliday($date = null): bool
    {
        $date = $date ?? now()->toDateString();
        return Holiday::where('tanggal', $date)->where('is_active', true)->exists();
    }

    public function isWeekend($date = null): bool
    {
        $date = Carbon::parse($date ?? now());
        return $date->isWeekend();
    }
}
