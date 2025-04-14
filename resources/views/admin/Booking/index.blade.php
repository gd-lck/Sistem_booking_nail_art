@extends('layouts.app')

@section('title', 'Booking')

@section('content')
<div class="content">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Id</th>
                <th>E-mail</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
            <tr>
                <th>{{ ($bookings->currentPage() - 1) * $bookings->perPage() + $loop->iteration }}</th>
                <td>{{ 'Book-'. $booking->id }}</td>
                <td>{{ $booking->user->email ?? '-' }}</td>
                <td>{{ $booking->layanan->nama_layanan ?? '-' }}</td>
                <td>{{ $booking->status }}</td>
                <td>
                    <button type="button" class="btn btn-warning">Detail</button>
                    <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
