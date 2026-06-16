@extends('layouts.admin')

@section('title', 'Laporan Kehadiran')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-graph-up"></i> Laporan Kehadiran</h4>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-2">
                <select name="bulan" class="form-select">
                    @for($i=1;$i<=12;$i++)
                        <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>{{ \Carbon\Carbon::create(null,$i,1)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2"><select name="tahun" class="form-select">@for($y=now()->year;$y>=now()->year-2;$y--)<option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>{{ $y }}</option>@endfor</select></div>
            <div class="col-md-3">
                <select name="department_id" class="form-select">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $d)<option value="{{ $d->id }}" {{ $departmentId==$d->id?'selected':'' }}>{{ $d->nama }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-sm">
            <thead><tr><th>NIK</th><th>Nama</th><th>Dept</th><th>Hadir</th><th>Terlambat</th><th>Alpha</th><th>Cuti</th></tr></thead>
            <tbody>
                @foreach($employees as $emp)
                @php
                    $a=$emp->attendances;
                @endphp
                <tr>
                    <td>{{ $emp->nik }}</td>
                    <td>{{ $emp->nama_lengkap }}</td>
                    <td>{{ $emp->department?->nama ?? '-' }}</td>
                    <td><span class="badge bg-success">{{ $a->where('status','hadir')->count() }}</span></td>
                    <td><span class="badge bg-warning">{{ $a->whereIn('status',['terlambat','terlambat_izin'])->count() }}</span></td>
                    <td><span class="badge bg-danger">{{ $a->where('status','alpha')->count() }}</span></td>
                    <td><span class="badge bg-info">{{ $a->where('status','cuti')->count() }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
