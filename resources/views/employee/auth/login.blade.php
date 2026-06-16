@extends('layouts.app')

@section('title', 'Login Karyawan')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg" style="width: 400px; border-radius: 20px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-person-lock text-primary" style="font-size: 3rem;"></i>
                <h4 class="fw-bold mt-2">Login Karyawan</h4>
                <p class="text-muted">Masukkan NIK dan PIN</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('employee.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">NIK (Nomor Induk Karyawan)</label>
                    <input type="text" name="nik" class="form-control form-control-lg" value="{{ old('nik') }}" placeholder="Masukkan NIK" required autofocus style="border-radius: 12px;">
                </div>
                <div class="mb-4">
                    <label class="form-label">PIN</label>
                    <input type="password" name="pin" class="form-control form-control-lg" placeholder="Masukkan PIN" required maxlength="8" style="border-radius: 12px;">
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100" style="border-radius: 12px;">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>

            <hr class="my-4">
            <div class="text-center">
                <a href="{{ route('absen.index') }}" class="text-decoration-none">
                    <i class="bi bi-fingerprint"></i> Halaman Absen
                </a>
                <span class="mx-2">|</span>
                <a href="{{ route('admin.login') }}" class="text-decoration-none">
                    <i class="bi bi-shield-lock"></i> Admin Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
