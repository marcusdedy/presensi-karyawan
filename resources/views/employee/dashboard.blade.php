@extends('layouts.employee')

@section('title', 'Dashboard Karyawan')

@section('employee_content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold">Selamat Datang, {{ $employee->nama_lengkap }}!</h4>
        <p class="text-muted">{{ $employee->department?->nama }} - {{ $employee->position?->nama }}</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-check text-success" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mt-2">{{ $stats['hadir'] }}</h3>
                <p class="text-muted mb-0">Hadir Bulan Ini</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mt-2">{{ $stats['terlambat'] }}</h3>
                <p class="text-muted mb-0">Terlambat</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-calendar-x text-danger" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mt-2">{{ $stats['alpha'] }}</h3>
                <p class="text-muted mb-0">Alpha</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-airplane text-info" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mt-2">{{ $sisaCuti }}</h3>
                <p class="text-muted mb-0">Sisa Cuti</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-clock"></i> Status Presensi Hari Ini
            </div>
            <div class="card-body">
                @if($todayAttendance)
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Status</td>
                            <td><span class="badge bg-{{ $todayAttendance->status_badge }}">{{ $todayAttendance->status_label }}</span></td>
                        </tr>
                        <tr>
                            <td>Jam Masuk</td>
                            <td><strong>{{ $todayAttendance->jam_masuk ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Jam Keluar</td>
                            <td><strong>{{ $todayAttendance->jam_keluar ?? '-' }}</strong></td>
                        </tr>
                        @if($todayAttendance->keterangan)
                        <tr>
                            <td>Keterangan</td>
                            <td><small class="text-muted">{{ $todayAttendance->keterangan }}</small></td>
                        </tr>
                        @endif
                    </table>
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                        <p class="mt-2 text-muted">Anda belum absen hari ini.</p>
                        <a href="{{ route('absen.index') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-fingerprint"></i> Absen Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-lightning"></i> Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('absen.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-fingerprint"></i> Absen
                    </a>
                    <a href="{{ route('employee.leave.create') }}" class="btn btn-outline-success">
                        <i class="bi bi-calendar-plus"></i> Ajukan Cuti
                    </a>
                    <a href="{{ route('employee.permission.create') }}" class="btn btn-outline-warning">
                        <i class="bi bi-clock-history"></i> Ajukan Izin
                    </a>
                    <a href="{{ route('employee.overtime.create') }}" class="btn btn-outline-info">
                        <i class="bi bi-alarm"></i> Ajukan Lembur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
