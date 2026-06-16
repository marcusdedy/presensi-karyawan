@extends('layouts.admin')

@section('title', 'Tambah Karyawan')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-person-plus"></i> Tambah Karyawan</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">NIK *</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">PIN *</label>
                    <input type="text" name="pin" class="form-control" required placeholder="Min 4, Max 8 digit">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="department_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($departments as $d)<option value="{{ $d->id }}">{{ $d->nama }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="position_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($positions as $p)<option value="{{ $p->id }}">{{ $p->nama }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Shift</label>
                    <select name="work_shift_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($shifts as $s)<option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->jam_masuk }}-{{ $s->jam_keluar }})</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Masuk *</label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', now()->toDateString()) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status Karyawan</label>
                    <select name="status_karyawan" class="form-select">
                        <option value="tetap">Tetap</option>
                        <option value="kontrak">Kontrak</option>
                        <option value="probation">Probation</option>
                        <option value="magang">Magang</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Agama</label>
                    <input type="text" name="agama" class="form-control" value="{{ old('agama') }}">
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
