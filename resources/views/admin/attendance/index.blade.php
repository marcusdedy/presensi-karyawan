@extends('layouts.admin')

@section('title', 'Presensi Harian')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-calendar-check"></i> Presensi Harian</h4>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>NIK</th><th>Nama</th><th>Dept</th><th>Masuk</th><th>Keluar</th><th>Status</th><th>Ket</th></tr>
                </thead>
                <tbody>
                    @forelse($attendances as $a)
                    <tr>
                        <td>{{ $a->employee->nik }}</td>
                        <td>{{ $a->employee->nama_lengkap }}</td>
                        <td>{{ $a->employee->department?->nama ?? '-' }}</td>
                        <td>{{ $a->jam_masuk ?? '-' }}</td>
                        <td>{{ $a->jam_keluar ?? '-' }}</td>
                        <td><span class="badge bg-{{ $a->status_badge }}">{{ $a->status_label }}</span></td>
                        <td><small>{{ $a->keterangan ?? '-' }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $attendances->links() }}
    </div>
</div>
@endsection
