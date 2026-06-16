@extends('layouts.employee')

@section('title', 'Riwayat Lembur')

@section('employee_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-alarm"></i> Riwayat Pengajuan Lembur</h4>
    <a href="{{ route('employee.overtime.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Ajukan Lembur</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Tipe Hari</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overtimes as $ot)
                    <tr>
                        <td>{{ $ot->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $ot->jam_mulai }} - {{ $ot->jam_selesai }}</td>
                        <td>{{ $ot->durasi_formatted }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($ot->tipe_hari) }}</span></td>
                        <td><small>{{ Str::limit($ot->alasan, 30) }}</small></td>
                        <td><span class="badge bg-{{ $ot->status_badge }}">{{ ucfirst($ot->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada pengajuan lembur.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $overtimes->links() }}
    </div>
</div>
@endsection
