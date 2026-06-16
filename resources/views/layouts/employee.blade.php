@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('employee.dashboard') }}">
            <i class="bi bi-clock-history"></i> Presensi App
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEmployee">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarEmployee">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.attendance.*') ? 'active' : '' }}" href="{{ route('employee.attendance.index') }}">
                        <i class="bi bi-calendar-check"></i> Presensi
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('employee.leave.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar-x"></i> Cuti
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('employee.leave.create') }}">Ajukan Cuti</a></li>
                        <li><a class="dropdown-item" href="{{ route('employee.leave.index') }}">Riwayat</a></li>
                        <li><a class="dropdown-item" href="{{ route('employee.leave.balance') }}">Sisa Cuti</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.permission.*') ? 'active' : '' }}" href="{{ route('employee.permission.index') }}">
                        <i class="bi bi-clock"></i> Perizinan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.overtime.*') ? 'active' : '' }}" href="{{ route('employee.overtime.index') }}">
                        <i class="bi bi-alarm"></i> Lembur
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ session('employee_nama') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('employee.profile.index') }}"><i class="bi bi-person"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('employee.profile.career') }}"><i class="bi bi-graph-up"></i> Riwayat Karir</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('employee.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('employee_content')
</div>
@endsection
