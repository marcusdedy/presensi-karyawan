@extends('layouts.admin')

@section('title', 'Approval Perizinan')

@section('admin_content')
<h4 class="fw-bold mb-4"><i class="bi bi-check-circle"></i> Approval Perizinan</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>Nama</th><th>Tipe</th><th>Tanggal</th><th>Jam</th><th>Durasi</th><th>Alasan</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($permissionRequests as $pr)
                    <tr>
                        <td>{{ $pr->employee->nama_lengkap }}</td>
                        <td><span class="badge bg-info">{{ $pr->tipe_label }}</span></td>
                        <td>{{ $pr->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $pr->jam_rencana }}</td>
                        <td>{{ intdiv($pr->durasi_menit,60) }}j {{ $pr->durasi_menit%60 }}m</td>
                        <td><small>{{ Str::limit($pr->alasan, 30) }}</small></td>
                        <td><span class="badge bg-{{ $pr->status_badge }}">{{ ucfirst($pr->status) }}</span></td>
                        <td>
                            @if($pr->status === 'pending')
                            <form action="{{ route('admin.approval.permission.approve', $pr) }}" method="POST" class="d-inline">
                                @csrf <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                            </form>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectPerm{{ $pr->id }}"><i class="bi bi-x"></i></button>
                            <div class="modal fade" id="rejectPerm{{ $pr->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
                                <form action="{{ route('admin.approval.permission.reject', $pr) }}" method="POST">@csrf
                                    <div class="modal-header"><h5 class="modal-title">Tolak Izin</h5></div>
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
        {{ $permissionRequests->links() }}
    </div>
</div>
@endsection
