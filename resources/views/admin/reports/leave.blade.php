@extends('layouts.admin')

@section('title', 'Laporan Cuti')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-calendar-x"></i> Laporan Cuti {{ $tahun }}</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>NIK</th><th>Nama</th><th>Dept</th><th>Jenis Cuti</th><th>Jatah</th><th>Terpakai</th><th>Sisa</th></tr></thead>
            <tbody>
                @foreach($balances as $empId => $empBalances)
                    @foreach($empBalances as $b)
                    <tr>
                        <td>{{ $b->employee->nik }}</td>
                        <td>{{ $b->employee->nama_lengkap }}</td>
                        <td>{{ $b->employee->department?->nama ?? '-' }}</td>
                        <td>{{ $b->leaveType->nama }}</td>
                        <td>{{ $b->jatah }}</td>
                        <td>{{ $b->terpakai }}</td>
                        <td><span class="badge bg-{{ $b->sisa > 3 ? 'success' : ($b->sisa > 0 ? 'warning' : 'danger') }}">{{ $b->sisa }}</span></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
