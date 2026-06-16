@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg" style="width: 400px; border-radius: 20px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-shield-lock text-dark" style="font-size: 3rem;"></i>
                <h4 class="fw-bold mt-2">Admin Login</h4>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" value="{{ old('username') }}" required style="border-radius: 12px;">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required style="border-radius: 12px;">
                </div>
                <button type="submit" class="btn btn-dark btn-lg w-100" style="border-radius: 12px;">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
