@extends('layouts.app')

@section('title', 'Absen Berhasil')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg" style="width: 400px; border-radius: 20px;">
        <div class="card-body p-5 text-center">
            <div class="mb-3">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            </div>
            <h4 class="fw-bold">Absen {{ ucfirst($tipe) }} Berhasil!</h4>
            <p class="text-muted">{{ $employee->nama_lengkap }}</p>
            <p class="mb-0">
                <i class="bi bi-clock"></i>
                {{ $tipe === 'masuk' ? $attendance->jam_masuk : $attendance->jam_keluar }}
            </p>

            <a href="{{ route('absen.index') }}" class="btn btn-primary mt-4" style="border-radius: 15px;">
                <i class="bi bi-arrow-left"></i> Kembali ke Halaman Absen
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($motivation)
    Swal.fire({
        title: '{{ $tipe === "masuk" ? "Selamat Datang, " . $employee->nama_lengkap . "!" : "Terima Kasih, " . $employee->nama_lengkap . "!" }}',
        html: `
            @if($motivation->gif_url)
            <img src="{{ $motivation->gif_url }}" style="width: 180px; height: 180px; border-radius: 12px; margin: 10px 0; object-fit: cover;" alt="motivasi">
            @endif
            <p style="font-size: 15px; color: #555; margin-top: 15px; line-height: 1.6;">
                "{{ $motivation->pesan }}"
            </p>
        `,
        confirmButtonText: '{{ $tipe === "masuk" ? "OK, Semangat! \ud83d\udcaa" : "Sampai Jumpa! \ud83d\udc4b" }}',
        confirmButtonColor: '{{ $tipe === "masuk" ? "#10b981" : "#6366f1" }}',
        background: '{{ $tipe === "masuk" ? "#f0fdf4" : "#eef2ff" }}',
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' },
        allowOutsideClick: false,
    });
    @endif
});
</script>
@endpush
@endsection
