@extends('layouts.admin')

@section('title', 'Laporan Lembur')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-alarm"></i> Laporan Lembur</h4>

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
            <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-search"></i></button></div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Nama</th><th>Dept</th><th>Hari Kerja</th><th>Hari Libur</th><th>Total</th></tr></thead>
            <tbody>
                @forelse($overtimes as $empId => $ots)
                @php
                    $emp = $ots->first()->employee;
                    $hariKerja = $ots->where('tipe_hari','kerja')->sum('durasi_menit');
                    $hariLibur = $ots->whereIn('tipe_hari',['libur','weekend'])->sum('durasi_menit');
                    $total = $hariKerja + $hariLibur;
                @endphp
                <tr>
                    <td>{{ $emp->nama_lengkap }}</td>
                    <td>{{ $emp->department?->nama ?? '-' }}</td>
                    <td>{{ round($hariKerja/60,1) }} jam</td>
                    <td>{{ round($hariLibur/60,1) }} jam</td>
                    <td><strong>{{ round($total/60,1) }} jam</strong></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data lembur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
