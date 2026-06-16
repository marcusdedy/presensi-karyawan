@extends('layouts.app')

@section('title', 'Absen Karyawan')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg" style="width: 420px; border-radius: 20px;">
        <div class="card-body p-5 text-center">
            <div class="mb-4">
                <i class="bi bi-fingerprint text-primary" style="font-size: 4rem;"></i>
            </div>
            <h3 class="fw-bold mb-2">Presensi Karyawan</h3>
            <p class="text-muted mb-4">Masukkan NIK dan PIN untuk absen</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('absen.verify') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="nik" class="form-control form-control-lg text-center"
                           placeholder="Nomor Induk Karyawan (NIK)" value="{{ old('nik') }}" autofocus
                           style="border-radius: 15px;">
                </div>
                <div class="mb-4">
                    <input type="password" name="pin" class="form-control form-control-lg text-center"
                           placeholder="Masukkan PIN" maxlength="8"
                           style="font-size: 1.5rem; letter-spacing: 10px; border-radius: 15px;">
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 15px;">
                    <i class="bi bi-check-circle"></i> Verifikasi
                </button>
            </form>

            <hr class="my-4">
            <p class="text-muted small mb-0">
                <a href="{{ route('employee.login') }}" class="text-decoration-none">
                    <i class="bi bi-box-arrow-in-right"></i> Login Panel Karyawan
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
