@extends('layouts.employee')

@section('title', 'Riwayat Cuti')

@section('employee_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-calendar-x"></i> Riwayat Pengajuan Cuti</h4>
    <a href="{{ route('employee.leave.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Ajukan Cuti</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Hari</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $leave)
                    <tr>
                        <td>{{ $leave->tanggal_mulai->format('d/m/Y') }} - {{ $leave->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>{{ $leave->leaveType->nama }}</td>
                        <td>{{ $leave->jumlah_hari }}</td>
                        <td><small>{{ Str::limit($leave->alasan, 40) }}</small></td>
                        <td><span class="badge bg-{{ $leave->status_badge }}">{{ ucfirst($leave->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada pengajuan cuti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $leaveRequests->links() }}
    </div>
</div>
@endsection
