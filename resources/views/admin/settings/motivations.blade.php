@extends('layouts.admin')

@section('title', 'Motivasi')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-chat-heart"></i> Kelola Motivasi</h4>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white fw-bold">Tambah Motivasi</div>
    <div class="card-body">
        <form action="{{ route('admin.settings.motivations.store') }}" method="POST">
            @csrf
            <div class="row g-2">
                <div class="col-md-2">
                    <select name="tipe" class="form-select" required>
                        <option value="masuk">Masuk</option>
                        <option value="pulang">Pulang</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="kategori" class="form-control" placeholder="Kategori" value="umum" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="pesan" class="form-control" placeholder="Pesan motivasi" required>
                </div>
                <div class="col-md-2">
                    <input type="url" name="gif_url" class="form-control" placeholder="URL GIF (opsional)">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100"><i class="bi bi-plus"></i> Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-sm">
            <thead><tr><th>Tipe</th><th>Kategori</th><th>Pesan</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($motivations as $m)
                <tr>
                    <td><span class="badge bg-{{ $m->tipe=='masuk'?'success':'info' }}">{{ ucfirst($m->tipe) }}</span></td>
                    <td>{{ $m->kategori }}</td>
                    <td><small>{{ Str::limit($m->pesan, 60) }}</small></td>
                    <td>
                        <form action="{{ route('admin.settings.motivations.destroy', $m) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $motivations->links() }}
    </div>
</div>
@endsection
