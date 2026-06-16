@extends('layouts.admin')

@section('title', 'Master Shift')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-clock-history"></i> Master Shift</h4>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Tambah Shift</div>
    <div class="card-body">
        <form action="{{ route('admin.shifts.store') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-3"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Jam Masuk</label><input type="time" name="jam_masuk" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Jam Keluar</label><input type="time" name="jam_keluar" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Toleransi (menit)</label><input type="number" name="toleransi_terlambat_menit" class="form-control" value="15" required></div>
            <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</button></div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Nama</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Toleransi</th><th>Status</th></tr></thead>
            <tbody>
                @foreach($shifts as $s)
                <tr>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->jam_masuk }}</td>
                    <td>{{ $s->jam_keluar }}</td>
                    <td>{{ $s->toleransi_terlambat_menit }} menit</td>
                    <td><span class="badge bg-{{ $s->is_active ? 'success' : 'secondary' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
