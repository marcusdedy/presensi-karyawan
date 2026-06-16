@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people"></i> Data Karyawan</h4>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah</a>
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama / NIK" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="department_id" class="form-select">
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>NIK</th><th>Nama</th><th>Departemen</th><th>Jabatan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                    <tr>
                        <td>{{ $emp->nik }}</td>
                        <td>{{ $emp->nama_lengkap }}</td>
                        <td>{{ $emp->department?->nama ?? '-' }}</td>
                        <td>{{ $emp->position?->nama ?? '-' }}</td>
                        <td><span class="badge bg-{{ $emp->status == 'aktif' ? 'success' : 'danger' }}">{{ ucfirst($emp->status) }}</span></td>
                        <td>
                            <a href="{{ route('admin.employees.show', $emp) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.employees.edit', $emp) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $employees->links() }}
    </div>
</div>
@endsection
