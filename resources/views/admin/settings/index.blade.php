@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-gear"></i> Pengaturan Sistem</h4>

<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @foreach($settings as $group => $items)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white fw-bold">{{ ucfirst($group) }}</div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($items as $setting)
                <div class="col-md-4">
                    <label class="form-label">{{ $setting->keterangan ?? $setting->key }}</label>
                    <input type="text" name="settings[{{ $setting->key }}]" class="form-control" value="{{ $setting->value }}">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Pengaturan</button>
</form>
@endsection
