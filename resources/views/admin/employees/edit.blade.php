@extends('layouts.admin')

@section('title', 'Edit Karyawan')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-pencil-square"></i> Edit Karyawan: {{ $employee->nama_lengkap }}</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">NIK *</label>
                    <input type="text" name="nik" class="form-control" value="{{ $employee->nik }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ $employee->nama_lengkap }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">PIN (kosongi jika tidak ganti)</label>
                    <input type="text" name="pin" class="form-control" placeholder="Biarkan kosong">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="department_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($departments as $d)<option value="{{ $d->id }}" {{ $employee->department_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jabatan</label>
                    <select name="position_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($positions as $p)<option value="{{ $p->id }}" {{ $employee->position_id == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Shift</label>
                    <select name="work_shift_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($shifts as $s)<option value="{{ $s->id }}" {{ $employee->work_shift_id == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" {{ $employee->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $employee->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="resign" {{ $employee->status == 'resign' ? 'selected' : '' }}>Resign</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status Karyawan</label>
                    <select name="status_karyawan" class="form-select">
                        <option value="tetap" {{ $employee->status_karyawan == 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="kontrak" {{ $employee->status_karyawan == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="probation" {{ $employee->status_karyawan == 'probation' ? 'selected' : '' }}>Probation</option>
                        <option value="magang" {{ $employee->status_karyawan == 'magang' ? 'selected' : '' }}>Magang</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ $employee->tanggal_masuk->format('Y-m-d') }}">
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
