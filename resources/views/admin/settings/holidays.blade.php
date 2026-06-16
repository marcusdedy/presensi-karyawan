@extends('layouts.admin')

@section('title', 'Hari Libur')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-calendar-x"></i> Hari Libur</h4>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Tambah Hari Libur</div>
    <div class="card-body">
        <form action="{{ route('admin.settings.holidays.store') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
            <div class="col-md-3"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" required></div>
            <div class="col-md-2"><label class="form-label">Tipe</label>
                <select name="tipe" class="form-select">
                    <option value="nasional">Nasional</option>
                    <option value="cuti_bersama">Cuti Bersama</option>
                    <option value="perusahaan">Perusahaan</option>
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</button></div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>Tanggal</th><th>Nama</th><th>Tipe</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($holidays as $h)
                <tr>
                    <td>{{ $h->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $h->nama }}</td>
                    <td><span class="badge bg-info">{{ ucfirst(str_replace('_',' ',$h->tipe)) }}</span></td>
                    <td>
                        <form action="{{ route('admin.settings.holidays.destroy', $h) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $holidays->links() }}
    </div>
</div>
@endsection
