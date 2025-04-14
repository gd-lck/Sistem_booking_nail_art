
    
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="admin-profil">
            <img src="{{ asset('assets/image/layananBasic1.jpg') }}">
            <h4>Admin</h4>
        </div>
        <a href="#"> Dashboard</a>
        <a href="#"> Profil Perusahaan</a>
        <a href="#"> Data User</a>
        <a href="{{ route('karyawan.index') }}">Data Karyawan</a>
        <a href="{{ route('jadwal.index') }}">Jadwal Karyawan</a>
        <a href="{{ route('layanan.index') }}"> Layanan</a>
        <a href="{{ route('booking.index')}}"> Booking</a>
        <a href="#"> Laporan</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="logout" href="{{route('logout')}}"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </nav>
