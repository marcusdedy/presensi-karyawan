@extends('layouts.employee')

@section('title', 'Ajukan Lembur')

@section('employee_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-alarm"></i> Form Pengajuan Lembur
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                <form action="{{ route('employee.overtime.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Hari <span class="text-danger">*</span></label>
                        <select name="tipe_hari" class="form-select" required>
                            <option value="kerja" {{ old('tipe_hari')=='kerja'?'selected':'' }}>Hari Kerja</option>
                            <option value="libur" {{ old('tipe_hari')=='libur'?'selected':'' }}>Hari Libur</option>
                            <option value="weekend" {{ old('tipe_hari')=='weekend'?'selected':'' }}>Weekend</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Alasan/Pekerjaan <span class="text-danger">*</span></label>
                        <textarea name="alasan" class="form-control" rows="3" required>{{ old('alasan') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employee.overtime.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
