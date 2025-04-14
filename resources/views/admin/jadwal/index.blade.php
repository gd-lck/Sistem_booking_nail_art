@extends('layouts.app')
@section('title', 'Jadwal')
@section('content')
<div class="container">
    <h2>Jadwal Karyawan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Tombol untuk menampilkan modal tambah jadwal -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahJadwalModal">Tambah Jadwal</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hari</th>
                @foreach($karyawans as $karyawan)
                    <th>{{ $karyawan->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($jadwals as $tanggal => $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}</td>
                @foreach($karyawans as $karyawan)
                    <td>
                        @php
                            $jadwal = $data->firstWhere('karyawan_id', $karyawan->id);
                        @endphp
                        @if($jadwal)
                            {{ ucfirst($jadwal->shift) }}
                            <br>
                            <!-- Tombol Edit -->
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $jadwal->id }}">Edit</button>

                            <!-- Form Hapus -->
                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus jadwal ini?')">Hapus</button>
                            </form>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal{{ $jadwal->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Jadwal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="karyawan_id" class="form-label">karyawan</label>
                                                    <select name="karyawan_id" class="form-control">
                                                        @foreach($karyawans as $karyawan)
                                                            <option value="{{ $karyawan->id }}" {{ $karyawan->id == $jadwal->karyawan_id ? 'selected' : '' }}>
                                                                {{ $karyawan->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="shift" class="form-label">Shift</label>
                                                    <select name="shift" class="form-control">
                                                        <option value="opening" {{ $jadwal->shift == 'opening' ? 'selected' : '' }}>Opening (08:00 - 17:00)</option>
                                                        <option value="middle" {{ $jadwal->shift == 'middle' ? 'selected' : '' }}>Middle (11:00 - 20:00)</option>
                                                        <option value="closing" {{ $jadwal->shift == 'closing' ? 'selected' : '' }}>Closing (13:00 - 22:00)</option>
                                                        <option value="libur" {{ $jadwal->shift == 'libur' ? 'selected' : '' }}>Libur</option>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            Belum dijadwalkan
                        @endif
                    </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJadwalModalLabel">Tambah Jadwal Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="karyawan_id" class="form-label">Pilih karyawan</label>
                            <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                                @foreach($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift</label>
                            <select name="shift" id="shift" class="form-control" required>
                                <option value="opening">Opening (08:00 - 17:00)</option>
                                <option value="middle">Middle (11:00 - 20:00)</option>
                                <option value="closing">Closing (13:00 - 22:00)</option>
                                <option value="libur">Libur</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS (Pastikan sudah ada di layout utama) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
