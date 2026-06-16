@extends('layouts.employee')

@section('title', 'Profil Saya')

@section('employee_content')
<h4 class="fw-bold mb-4"><i class="bi bi-person"></i> Profil Saya</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td class="text-muted">NIK</td><td><strong>{{ $employee->nik }}</strong></td></tr>
                    <tr><td class="text-muted">Nama</td><td>{{ $employee->nama_lengkap }}</td></tr>
                    <tr><td class="text-muted">Jenis Kelamin</td><td>{{ $employee->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><td class="text-muted">Tempat, Tgl Lahir</td><td>{{ $employee->tempat_lahir }}, {{ $employee->tanggal_lahir?->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Agama</td><td>{{ $employee->agama }}</td></tr>
                    <tr><td class="text-muted">No. HP</td><td>{{ $employee->no_hp }}</td></tr>
                    <tr><td class="text-muted">Email</td><td>{{ $employee->email }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><td class="text-muted">Departemen</td><td>{{ $employee->department?->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Jabatan</td><td>{{ $employee->position?->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Shift</td><td>{{ $employee->workShift?->nama ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td><span class="badge bg-success">{{ ucfirst($employee->status_karyawan) }}</span></td></tr>
                    <tr><td class="text-muted">Tanggal Masuk</td><td>{{ $employee->tanggal_masuk->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted">Masa Kerja</td><td>{{ $employee->tanggal_masuk->diffForHumans(null, true) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
