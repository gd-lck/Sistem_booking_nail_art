
<header>
    <nav>
        <a href="#section1">Beranda</a>
        <a href="#section2">Tentang</a>
        <a href="#section3">Kontak</a>
        <a href=" {{ route('customer.layanan.display') }} ">Layanan</a>
        <a href =" {{ route('customer.booking') }}">Booking</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a class="logout" href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </nav>
</header>