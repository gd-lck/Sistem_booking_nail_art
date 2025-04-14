@extends('layouts.app')

@section('title', 'Karyawan')

@section('content')
    <div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status Kerja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $item)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->status_kerja }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal{{ $item->id }}">Update</button>
                        <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Update -->
                <div class="modal fade" id="updateModal{{ $item->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel{{ $item->id }}">Update Data Karyawan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('karyawan.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status_kerja" class="form-label">Status Kerja</label>
                                        <select class="form-control" name="status_kerja" required>
                                            <option value="Tersedia" {{ $item->status_kerja == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="Tidak Tersedia" {{ $item->status_kerja == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
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
                        <h5 class="modal-title" id="inputModalLabel">Tambah Data Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('karyawan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_kerja" class="form-label">Status Kerja</label>
                                <select class="form-control" name="status_kerja" required>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                                </select>
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
