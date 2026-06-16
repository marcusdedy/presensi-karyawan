@extends('layouts.admin')

@section('title', 'Jadwal Shift')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-calendar-week"></i> Jadwal Shift Karyawan</h4>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3"><input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai }}"></div>
            <div class="col-md-3"><input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggalSelesai }}"></div>
            <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @php
            $dateRange = \Carbon\CarbonPeriod::create($tanggalMulai, $tanggalSelesai);
        @endphp
        <div class="table-responsive">
            <table class="table table-bordered table-sm text-center">
                <thead>
                    <tr>
                        <th>Nama</th>
                        @foreach($dateRange as $date)
                            <th>{{ $date->format('d') }}<br><small>{{ $date->translatedFormat('D') }}</small></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                    <tr>
                        <td class="text-start">{{ $emp->nama_lengkap }}</td>
                        @foreach($dateRange as $date)
                            @php
                                $empShift = $emp->employeeShifts->firstWhere('tanggal', $date->toDateString());
                            @endphp
                            <td>
                                <small>{{ $empShift ? $empShift->workShift->nama : ($emp->workShift?->nama ?? '-') }}</small>
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
