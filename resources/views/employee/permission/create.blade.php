@extends('layouts.employee')

@section('title', 'Ajukan Izin')

@section('employee_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-clock-history"></i> Form Permohonan Izin
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('employee.permission.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tipe Izin <span class="text-danger">*</span></label>
                        <select name="tipe" class="form-select" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="terlambat" {{ old('tipe') == 'terlambat' ? 'selected' : '' }}>Izin Datang Terlambat</option>
                            <option value="pulang_cepat" {{ old('tipe') == 'pulang_cepat' ? 'selected' : '' }}>Izin Pulang Cepat</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->toDateString()) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam <span class="text-danger">*</span></label>
                        <input type="time" name="jam_rencana" class="form-control" value="{{ old('jam_rencana') }}" required>
                        <small class="text-muted">Untuk terlambat: estimasi jam masuk. Untuk pulang cepat: jam pulang yang diminta.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan <span class="text-danger">*</span></label>
                        <textarea name="alasan" class="form-control" rows="3" required placeholder="Jelaskan alasan izin Anda (min. 10 karakter)">{{ old('alasan') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Lampiran (opsional)</label>
                        <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.png">
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employee.permission.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
