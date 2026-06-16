@extends('layouts.employee')

@section('title', 'Riwayat Karir')

@section('employee_content')
<h4 class="fw-bold mb-4"><i class="bi bi-graph-up"></i> Riwayat Karir</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($histories->isEmpty())
            <p class="text-center text-muted py-4">Belum ada riwayat karir.</p>
        @else
            <div class="timeline">
                @foreach($histories as $history)
                <div class="d-flex mb-4">
                    <div class="me-3 text-center" style="min-width: 80px;">
                        <small class="text-muted">{{ $history->tanggal_efektif->format('d M Y') }}</small>
                    </div>
                    <div class="border-start border-3 border-primary ps-3">
                        <h6 class="fw-bold mb-1">
                            <i class="{{ $history->tipe_icon }}"></i>
                            {{ $history->tipe_label }}
                        </h6>
                        @if($history->jabatan_lama || $history->jabatan_baru)
                            <p class="mb-1">Jabatan: {{ $history->jabatan_lama ?? '-' }} &rarr; <strong>{{ $history->jabatan_baru ?? '-' }}</strong></p>
                        @endif
                        @if($history->departemen_lama || $history->departemen_baru)
                            <p class="mb-1">Dept: {{ $history->departemen_lama ?? '-' }} &rarr; <strong>{{ $history->departemen_baru ?? '-' }}</strong></p>
                        @endif
                        @if($history->status_lama || $history->status_baru)
                            <p class="mb-1">Status: {{ $history->status_lama ?? '-' }} &rarr; <strong>{{ $history->status_baru ?? '-' }}</strong></p>
                        @endif
                        @if($history->no_sk)
                            <small class="text-muted">SK: {{ $history->no_sk }}</small>
                        @endif
                        @if($history->catatan)
                            <p class="text-muted small mb-0">{{ $history->catatan }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
