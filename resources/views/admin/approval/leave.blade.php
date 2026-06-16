@extends('layouts.admin')

@section('title', 'Approval Cuti')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-check-circle"></i> Approval Pengajuan Cuti</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Nama</th><th>Jenis Cuti</th><th>Tanggal</th><th>Hari</th><th>Alasan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($leaveRequests as $lr)
                    <tr>
                        <td>{{ $lr->employee->nama_lengkap }}<br><small class="text-muted">{{ $lr->employee->nik }}</small></td>
                        <td>{{ $lr->leaveType->nama }}</td>
                        <td>{{ $lr->tanggal_mulai->format('d/m/Y') }} - {{ $lr->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>{{ $lr->jumlah_hari }}</td>
                        <td><small>{{ Str::limit($lr->alasan, 40) }}</small></td>
                        <td><span class="badge bg-{{ $lr->status_badge }}">{{ ucfirst($lr->status) }}</span></td>
                        <td>
                            @if($lr->status === 'pending')
                            <form action="{{ route('admin.approval.leave.approve', $lr) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                            </form>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectLeave{{ $lr->id }}"><i class="bi bi-x"></i></button>
                            <div class="modal fade" id="rejectLeave{{ $lr->id }}" tabindex="-1">
                                <div class="modal-dialog"><div class="modal-content">
                                    <form action="{{ route('admin.approval.leave.reject', $lr) }}" method="POST">
                                        @csrf
                                        <div class="modal-header"><h5 class="modal-title">Tolak Cuti</h5></div>
                                        <div class="modal-body">
                                            <textarea name="catatan" class="form-control" required placeholder="Alasan penolakan (min 5 karakter)"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                        </div>
                                    </form>
                                </div></div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $leaveRequests->links() }}
    </div>
</div>
@endsection
