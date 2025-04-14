@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form Booking</h2>

    <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
        @csrf

        {{-- Pilih Layanan --}}
        <div class="mb-3">
            <label for="layanan_id" class="form-label">Pilih Layanan</label>
            <select name="layanan_id" id="layanan_id" class="form-select" required>
                <option value="">-- Pilih Layanan --</option>
                @foreach ($layanans as $layanan)
                    <option value="{{ $layanan->id }}"
                        @if (isset($layananTerpilih) && $layananTerpilih->id == $layanan->id) selected @endif>
                        {!! $layanan->nama_layanan !!} (<strong>Rp. {{ number_format($layanan->harga,0,',','.') }}</strong> {{ number_format($layanan->durasi,0,',','.') }} menit)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Booking --}}
        <div class="mb-3">
            <label for="booking_date" class="form-label">Tanggal Booking</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Jam Booking --}}
        <div class="mb-3">
            <label for="booking_time" class="form-label">Jam Booking</label>
            <input type="time" name="booking_time" id="booking_time" class="form-control" min="08:00" max="22:00" required>
            <div id="timeError" class="text-danger mt-1" style="display: none;">
                Jam booking hanya diperbolehkan antara 08:00 sampai 22:00.
            </div>
        </div>

        {{-- Karyawan Tersedia --}}
        {{-- Karyawan Tersedia --}}
        <div class="mb-3">
            <label for="karyawan_id" class="form-label">Pilih Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                <option value="">-- Pilih karyawan yang tersedia --</option>
            </select>
            <div id="hasil-karyawan" class="form-text text-muted">
                Pilih tanggal & jam untuk melihat karyawan yang tersedia.
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Booking Sekarang</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        const bookingDate = $('#booking_date');
        const bookingTime = $('#booking_time');
        const layananId = $('#layanan_id');
        const karyawanSelect = $('#karyawan_id');
        const hasilKaryawan = $('#hasil-karyawan');
        const timeError = $('#timeError');

        // Validasi jam booking
        $('#bookingForm').on('submit', function (e) {
            const timeValue = bookingTime.val();
            const [hour, minute] = timeValue.split(':');
            const h = parseInt(hour);

            if (h < 8 || h >= 22) {
                e.preventDefault();
                timeError.show();
                bookingTime.focus();
            } else {
                timeError.hide();
            }
        });

        // Cek karyawan saat tanggal, jam, atau layanan berubah
        bookingDate.on('change', fetchKaryawan);
        bookingTime.on('change', fetchKaryawan);
        layananId.on('change', fetchKaryawan);

        function fetchKaryawan() {
            let tanggal = bookingDate.val();
            let jam = bookingTime.val();
            let layanan = layananId.val();

            console.log(tanggal, jam, layanan);

            if (tanggal && jam && layanan) {
                $.ajax({
                    url: '{{ route("cek.karyawan") }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        tanggal: tanggal,
                        jam: jam,
                        layanan_id: layanan
                    },
                    success: function (res) {
                        karyawanSelect.empty();
                        if (res.length > 0) {
                            karyawanSelect.append('<option value="">-- Pilih karyawan yang tersedia --</option>');
                            res.forEach(karyawan => {
                                karyawanSelect.append(`<option value="${karyawan.id}">${karyawan.nama}</option>`);
                            });
                            hasilKaryawan.text('Silakan pilih salah satu karyawan dari daftar.');
                        } else {
                            karyawanSelect.append('<option value="">-- Tidak ada karyawan yang tersedia --</option>');
                            hasilKaryawan.text('Tidak ada karyawan yang tersedia di waktu tersebut.');
                        }
                    },
                    error: function () {
                        karyawanSelect.empty();
                        karyawanSelect.append('<option value="">-- Gagal memuat karyawan --</option>');
                        hasilKaryawan.text('Terjadi kesalahan saat memuat data.');
                    }
                });
            }
        }
    });
</script>
@endsection


