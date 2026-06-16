@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h4>

<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="fw-bold">{{ $stats['total_karyawan'] }}</h3>
                <small>Total Karyawan</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h3 class="fw-bold">{{ $stats['hadir_hari_ini'] }}</h3>
                <small>Hadir Hari Ini</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body text-center">
                <h3 class="fw-bold">{{ $stats['terlambat_hari_ini'] }}</h3>
                <small>Terlambat</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body text-center">
                <h3 class="fw-bold">{{ $stats['cuti_hari_ini'] }}</h3>
                <small>Cuti</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body text-center">
                <h3 class="fw-bold">{{ max(0, $stats['alpha_hari_ini']) }}</h3>
                <small>Alpha</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm bg-secondary text-white">
            <div class="card-body text-center">
                <h3 class="fw-bold">{{ $overtimeStats['total_jam'] }}</h3>
                <small>Jam Lembur (Bln Ini)</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="bi bi-clock-history"></i> Pending Approval</div>
            <div class="card-body">
                <a href="{{ route('admin.approval.leave') }}" class="d-flex justify-content-between py-2 text-decoration-none">
                    <span>Pengajuan Cuti</span>
                    <span class="badge bg-warning">{{ $pendingApprovals['cuti'] }}</span>
                </a>
                <a href="{{ route('admin.approval.permission') }}" class="d-flex justify-content-between py-2 text-decoration-none">
                    <span>Perizinan</span>
                    <span class="badge bg-warning">{{ $pendingApprovals['izin'] }}</span>
                </a>
                <a href="{{ route('admin.approval.overtime') }}" class="d-flex justify-content-between py-2 text-decoration-none">
                    <span>Lembur</span>
                    <span class="badge bg-warning">{{ $pendingApprovals['lembur'] }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold"><i class="bi bi-bar-chart"></i> Kehadiran Bulan Ini</div>
            <div class="card-body">
                @php
                    $total = array_sum($monthlyStats) ?: 1;
                @endphp
                @foreach($monthlyStats as $status => $count)
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <small>{{ ucfirst(str_replace('_', ' ', $status)) }}</small>
                        <small>{{ $count }}</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-{{ $status === 'hadir' ? 'success' : ($status === 'terlambat' ? 'danger' : 'warning') }}"
                             style="width: {{ ($count / $total) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
                @if(empty($monthlyStats))
                    <p class="text-muted text-center">Belum ada data bulan ini.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
