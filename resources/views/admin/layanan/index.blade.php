@extends('layouts.app')

@section('title', 'Beranda')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                <th>#</th>
                <th>Nama layanan</th>
                <th>harga</th>
                <th>Durasi</th>
                <th>Gambar</th>
                <th>Gambar2</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($layanan as $layanan)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $layanan->nama_layanan }}</td>
                    <td>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</td>
                    <td>{{ $layanan->durasi }} menit</td>
                    <td>
                        <img src="{{ asset('uploads/' . $layanan->gambar) }}" alt="Gambar {{ $layanan->nama_layanan }}" width="60">
                    </td>
                    <td>
                        <img src="{{ asset('uploads/' . $layanan->gambar2) }}" alt="Gambar {{ $layanan->nama_layanan }}" width="60">
                        <td>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $layanan->deskripsi }}">
                                {{ Str::words($layanan->deskripsi, 10, '...') }}
                            </span>
                        </td>
                        <td>                      
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal{{ $layanan->id }}">Update</button>
                            <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                </tr>

                <!-- Modal Update -->
                <div class="modal fade" id="updateModal{{ $layanan->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $layanan->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel{{ $layanan->id }}">Update Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                        <input type="text" class="form-control" name="nama_layanan" value="{{ $layanan->nama_layanan }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga: Rp</label>
                                        <input type="number" class="form-control" name="harga" value="{{ $layanan->harga }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="durasi" class="form-label">Durasi: Menit</label>
                                        <input type="number" class="form-control" name="durasi" value="{{ $layanan->durasi }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" name="deskripsi" rows="3" required>{{ $layanan->deskripsi }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Upload Gambar 1</label>
                                        <input type="file" class="form-control" name="gambar" accept="image/*">

                                        <label for="gambar2" class="form-label mt-3">Upload Gambar 2</label>
                                        <input type="file" class="form-control" name="gambar2" accept="image/*">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga: Rp</label>
                                <input type="number" class="form-control" id="harga" name="harga" required>
                            </div>
                            <div class="mb-3">
                                <label for="durasi" class="form-label">Durasi: Menit</label>
                                <input type="number" class="form-control" id="durasi" name="durasi" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Upload Gambar 1</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*" required>

                                <label for="gambar2" class="form-label mt-3">Upload Gambar 2</label>
                                <input type="file" class="form-control" name="gambar2" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputModal">Tambah Data</button>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
