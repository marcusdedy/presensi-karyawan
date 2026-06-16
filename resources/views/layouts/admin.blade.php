@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-gear-fill"></i> Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                        <i class="bi bi-people"></i> Karyawan
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar-check"></i> Presensi
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.attendance.index') }}">Harian</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.attendance.monthly') }}">Bulanan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.approval.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-check-circle"></i> Approval
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.approval.leave') }}">Cuti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.approval.permission') }}">Perizinan</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.approval.overtime') }}">Lembur</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.shifts.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-clock-history"></i> Shift
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.shifts.index') }}">Master Shift</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.shifts.schedule') }}">Jadwal Shift</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-graph-up"></i> Laporan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.reports.attendance') }}">Kehadiran</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.leave') }}">Cuti</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reports.overtime') }}">Lembur</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-gear"></i> Pengaturan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Umum</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.holidays') }}">Hari Libur</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.motivations') }}">Motivasi</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ session('admin_nama') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
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

<div class="container-fluid py-4">
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

    @yield('admin_content')
</div>
@endsection
