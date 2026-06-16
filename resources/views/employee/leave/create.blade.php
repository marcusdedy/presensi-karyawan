@extends('layouts.employee')

@section('title', 'Ajukan Cuti')

@section('employee_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-calendar-plus"></i> Form Pengajuan Cuti
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="alert alert-info mb-4">
                    <strong>Sisa Cuti Anda:</strong>
                    @foreach($balances as $balance)
                        <span class="badge bg-primary me-1">{{ $balance->leaveType->nama }}: {{ $balance->sisa }} hari</span>
                    @endforeach
                </div>

                <form action="{{ route('employee.leave.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                        <select name="leave_type_id" class="form-select" required>
                            <option value="">-- Pilih Jenis Cuti --</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->nama }} ({{ $type->jatah_hari }} hari)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alasan <span class="text-danger">*</span></label>
                        <textarea name="alasan" class="form-control" rows="3" required placeholder="Jelaskan alasan cuti Anda">{{ old('alasan') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Lampiran (opsional)</label>
                        <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.png">
                        <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('employee.leave.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Ajukan Cuti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
