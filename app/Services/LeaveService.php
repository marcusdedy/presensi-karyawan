<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Holiday;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Setting;
use Carbon\Carbon;

class LeaveService
{
    public function getSisaCuti(Employee $employee, LeaveType $leaveType, int $tahun = null): int
    {
        $tahun = $tahun ?? now()->year;

        $balance = LeaveBalance::where('employee_id', $employee->id)
            ->where('leave_type_id', $leaveType->id)
            ->where('tahun', $tahun)
            ->first();

        return $balance ? $balance->sisa : 0;
    }

    public function hitungHariKerja(string $tanggalMulai, string $tanggalSelesai): int
    {
        $start = Carbon::parse($tanggalMulai);
        $end = Carbon::parse($tanggalSelesai);
        $jumlahHari = 0;

        while ($start->lessThanOrEqualTo($end)) {
            if (!$start->isWeekend() && !$this->isHoliday($start->toDateString())) {
                $jumlahHari++;
            }
            $start->addDay();
        }

        return $jumlahHari;
    }

    public function ajukanCuti(Employee $employee, array $data): array
    {
        $leaveType = LeaveType::find($data['leave_type_id']);

        if (!$leaveType) {
            return ['success' => false, 'message' => 'Jenis cuti tidak ditemukan.'];
        }

        $jumlahHari = $this->hitungHariKerja($data['tanggal_mulai'], $data['tanggal_selesai']);

        if ($jumlahHari <= 0) {
            return ['success' => false, 'message' => 'Tanggal cuti tidak valid.'];
        }

        // Cek sisa cuti jika potong cuti
        if ($leaveType->potong_cuti) {
            $sisaCuti = $this->getSisaCuti($employee, $leaveType);
            if ($jumlahHari > $sisaCuti) {
                return ['success' => false, 'message' => "Sisa cuti tidak mencukupi. Sisa: {$sisaCuti} hari, Diajukan: {$jumlahHari} hari."];
            }
        }

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $data['leave_type_id'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'jumlah_hari' => $jumlahHari,
            'alasan' => $data['alasan'],
            'lampiran' => $data['lampiran'] ?? null,
            'status' => 'pending',
        ]);

        return ['success' => true, 'leaveRequest' => $leaveRequest, 'message' => 'Pengajuan cuti berhasil.'];
    }

    public function approveCuti(LeaveRequest $leaveRequest, int $adminId, ?string $catatan = null): array
    {
        $leaveRequest->update([
            'status' => 'disetujui',
            'approved_by' => $adminId,
            'catatan_approval' => $catatan,
        ]);

        // Update saldo cuti
        if ($leaveRequest->leaveType->potong_cuti) {
            $balance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)
                ->where('leave_type_id', $leaveRequest->leave_type_id)
                ->where('tahun', now()->year)
                ->first();

            if ($balance) {
                $balance->update([
                    'terpakai' => $balance->terpakai + $leaveRequest->jumlah_hari,
                    'sisa' => $balance->sisa - $leaveRequest->jumlah_hari,
                ]);
            }
        }

        return ['success' => true, 'message' => 'Cuti berhasil disetujui.'];
    }

    public function rejectCuti(LeaveRequest $leaveRequest, int $adminId, ?string $catatan = null): array
    {
        $leaveRequest->update([
            'status' => 'ditolak',
            'approved_by' => $adminId,
            'catatan_approval' => $catatan,
        ]);

        return ['success' => true, 'message' => 'Cuti berhasil ditolak.'];
    }

    private function isHoliday(string $date): bool
    {
        return Holiday::where('tanggal', $date)->where('is_active', true)->exists();
    }
}
