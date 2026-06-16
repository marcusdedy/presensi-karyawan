@extends('layouts.employee')

@section('title', 'Sisa Cuti')

@section('employee_content')
<h4 class="fw-bold mb-4"><i class="bi bi-pie-chart"></i> Sisa Cuti Tahun {{ now()->year }}</h4>

<div class="row g-3">
    @foreach($balances as $balance)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="fw-bold">{{ $balance->leaveType->nama }}</h5>
                <div class="my-3">
                    <span class="display-4 fw-bold text-primary">{{ $balance->sisa }}</span>
                    <span class="text-muted"> / {{ $balance->jatah }} hari</span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-success" style="width: {{ $balance->jatah > 0 ? ($balance->sisa / $balance->jatah * 100) : 0 }}%"></div>
                </div>
                <small class="text-muted mt-2 d-block">Terpakai: {{ $balance->terpakai }} hari</small>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
