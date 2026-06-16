@extends('layouts.app')

@section('title', 'Konfirmasi Absen')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg" style="width: 450px; border-radius: 20px;">
        <div class="card-body p-5 text-center">
            <div class="mb-4">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-check text-primary" style="font-size: 2.5rem;"></i>
                </div>
            </div>

            <h4 class="fw-bold mb-1">Halo, {{ $employee->nama_lengkap }}!</h4>
            <p class="text-muted">{{ $employee->department?->nama }} - {{ $employee->position?->nama }}</p>

            <div class="bg-light rounded-3 p-3 mb-4">
                <p class="mb-1"><i class="bi bi-calendar"></i> {{ now()->translatedFormat('l, d F Y') }}</p>
                <p class="mb-0"><i class="bi bi-clock"></i> {{ now()->format('H:i:s') }}</p>
            </div>

            @if($todayAttendance && $todayAttendance->jam_masuk)
                <p class="text-success small"><i class="bi bi-check-circle"></i> Sudah absen masuk: {{ $todayAttendance->jam_masuk }}</p>
            @endif

            <div class="d-grid gap-2">
                @if($canAbsenMasuk)
                    <form action="{{ route('absen.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="tipe" value="masuk">
                        <button type="submit" class="btn btn-success btn-lg w-100" style="border-radius: 15px;">
                            <i class="bi bi-box-arrow-in-right"></i> Absen Masuk
                        </button>
                    </form>
                @endif

                @if($canAbsenPulang)
                    <form action="{{ route('absen.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="tipe" value="pulang">
                        <button type="submit" class="btn btn-warning btn-lg w-100" style="border-radius: 15px;">
                            <i class="bi bi-box-arrow-right"></i> Absen Pulang
                        </button>
                    </form>
                @endif

                @if(!$canAbsenMasuk && !$canAbsenPulang)
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Anda sudah absen masuk dan pulang hari ini.
                    </div>
                @endif
            </div>

            <a href="{{ route('absen.index') }}" class="btn btn-outline-secondary mt-3" style="border-radius: 15px;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
