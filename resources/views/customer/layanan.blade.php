@extends('layouts.app')

@section('title', 'Beranda')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container my-4">
    <div class="row g-4">
        @foreach ($layanan as $layanan)
        <div class="col-md-4">
            <div class="card shadow-sm rounded h-100">
                <div class="d-flex">
                    <img src="{{ asset('uploads/' . $layanan->gambar) }}" class="img-fluid w-50 rounded-start" alt="Gambar {{ $layanan->nama_layanan }}">
                    <img src="{{ asset('uploads/' . $layanan->gambar2) }}" class="img-fluid w-50 rounded-end" alt="Gambar {{ $layanan->nama_layanan }}">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $layanan->nama_layanan }}</h5>
                    <h6 class="text-muted">Rp {{ number_format($layanan->harga, 0, ',', '.') }}</h6>
                    <p class="card-text mb-1">Durasi: {{  number_format($layanan->durasi, 0, ',', '.') }} menit</p>
                    <p class="card-text text-muted">{{ Str::words($layanan->deskripsi, 10, '...') }}</p>
                    <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $layanan->id }}">Lihat Detail</button>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="modalDetail{{ $layanan->id }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $layanan->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDetailLabel{{ $layanan->id }}">{{ $layanan->nama_layanan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <img src="{{ asset('uploads/' . $layanan->gambar) }}" class="img-fluid w-55 rounded mb-2" alt="Gambar {{ $layanan->nama_layanan }}">
                                <img src="{{ asset('uploads/' . $layanan->gambar2) }}" class="img-fluid w-55 rounded" alt="Gambar {{ $layanan->nama_layanan }}">
                            </div>
                            <div class="col-md-6">
                                <h6>Harga: <strong>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</strong></h6>
                                <p>Durasi: {{ number_format($layanan->durasi, 0, ',', '.') }} menit</p>
                                <p>{{ $layanan->deskripsi }}</p>
                                <a href="{{ route('booking.create', $layanan->id) }}" class="btn btn-success">Pesan Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
