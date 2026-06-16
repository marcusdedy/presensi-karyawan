@extends('layouts.admin')

@section('title', 'Approval Lembur')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-check-circle"></i> Approval Lembur</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Nama</th><th>Tanggal</th><th>Jam</th><th>Durasi</th><th>Tipe</th><th>Alasan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($overtimeRequests as $ot)
                    <tr>
                        <td>{{ $ot->employee->nama_lengkap }}</td>
                        <td>{{ $ot->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $ot->jam_mulai }} - {{ $ot->jam_selesai }}</td>
                        <td>{{ $ot->durasi_formatted }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($ot->tipe_hari) }}</span></td>
                        <td><small>{{ Str::limit($ot->alasan, 30) }}</small></td>
                        <td><span class="badge bg-{{ $ot->status_badge }}">{{ ucfirst($ot->status) }}</span></td>
                        <td>
                            @if($ot->status === 'pending')
                            <form action="{{ route('admin.approval.overtime.approve', $ot) }}" method="POST" class="d-inline">
                                @csrf <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                            </form>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectOT{{ $ot->id }}"><i class="bi bi-x"></i></button>
                            <div class="modal fade" id="rejectOT{{ $ot->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
                                <form action="{{ route('admin.approval.overtime.reject', $ot) }}" method="POST">@csrf
                                    <div class="modal-header"><h5 class="modal-title">Tolak Lembur</h5></div>
                                    <div class="modal-body"><textarea name="catatan" class="form-control" required placeholder="Alasan penolakan"></textarea></div>
                                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Tolak</button></div>
                                </form>
                            </div></div></div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $overtimeRequests->links() }}
    </div>
</div>
@endsection
