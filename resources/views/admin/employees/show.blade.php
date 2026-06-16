@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-person"></i> {{ $employee->nama_lengkap }}</h4>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Data Pribadi</div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted" width="40%">NIK</td><td>{{ $employee->nik }}</td></tr>
                    <tr><td class="text-muted">Nama</td><td>{{ $employee->nama_lengkap }}</td></tr>
                    <tr><td class="text-muted">Jenis Kelamin</td><td>{{ $employee->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><td class="text-muted">TTL</td><td>{{ $employee->tempat_lahir }}, {{ $employee->tanggal_lahir?->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Agama</td><td>{{ $employee->agama }}</td></tr>
                    <tr><td class="text-muted">No. HP</td><td>{{ $employee->no_hp }}</td></tr>
                    <tr><td class="text-muted">Email</td><td>{{ $employee->email }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Data Kepegawaian</div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><td class="text-muted" width="40%">Departemen</td><td>{{ $employee->department?->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Jabatan</td><td>{{ $employee->position?->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Shift</td><td>{{ $employee->workShift?->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td><span class="badge bg-{{ $employee->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($employee->status) }}</span></td></tr>
                    <tr><td class="text-muted">Status Karyawan</td><td>{{ ucfirst($employee->status_karyawan) }}</td></tr>
                    <tr><td class="text-muted">Tgl Masuk</td><td>{{ $employee->tanggal_masuk->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Masa Kerja</td><td>{{ $employee->tanggal_masuk->diffForHumans(null, true) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header bg-white fw-bold"><i class="bi bi-graph-up"></i> Riwayat Karir</div>
    <div class="card-body">
        @forelse($employee->careerHistories as $history)
        <div class="d-flex mb-3">
            <div class="me-3" style="min-width: 90px;"><small class="text-muted">{{ $history->tanggal_efektif->format('d/m/Y') }}</small></div>
            <div class="border-start border-3 border-primary ps-3">
                <strong><i class="{{ $history->tipe_icon }}"></i> {{ $history->tipe_label }}</strong>
                @if($history->jabatan_baru)<br><small>Jabatan: {{ $history->jabatan_lama ?? '-' }} &rarr; {{ $history->jabatan_baru }}</small>@endif
                @if($history->catatan)<br><small class="text-muted">{{ $history->catatan }}</small>@endif
            </div>
        </div>
        @empty
        <p class="text-muted">Belum ada riwayat.</p>
        @endforelse
    </div>
</div>
@endsection
