@extends('layouts.employee')

@section('title', 'Riwayat Perizinan')

@section('employee_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-clock-history"></i> Riwayat Perizinan</h4>
    <a href="{{ route('employee.permission.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Ajukan Izin</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $perm)
                    <tr>
                        <td>{{ $perm->tanggal->format('d/m/Y') }}</td>
                        <td><span class="badge bg-{{ $perm->tipe === 'terlambat' ? 'info' : 'purple' }}">{{ $perm->tipe_label }}</span></td>
                        <td>{{ $perm->jam_rencana }}</td>
                        <td>{{ intdiv($perm->durasi_menit, 60) }}j {{ $perm->durasi_menit % 60 }}m</td>
                        <td><small>{{ Str::limit($perm->alasan, 30) }}</small></td>
                        <td><span class="badge bg-{{ $perm->status_badge }}">{{ ucfirst($perm->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat perizinan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $permissions->links() }}
    </div>
</div>
@endsection
