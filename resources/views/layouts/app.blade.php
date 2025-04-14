<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Tambahkan link ke CSS atau JavaScript di sini jika diperlukan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('assets/css/landing_page.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @role('admin')
        <style>
            .content {
                margin-left: 260px;
                padding: 20px;
                flex-grow: 1;
            }
            
            body {
                min-height: 100vh;
                display: flex;
            }
            .sidebar {
                position : relative;
                width: 250px;
                height: 100vh;
                position: fixed;
                background-color: #343a40;
                color: white;
                padding: 20px;
            }
            .sidebar a {
                display: block;
                color: white;
                text-decoration: none;
                padding: 10px;
                border-radius: 5px;
            }
            .sidebar a:hover {
                background-color: #495057;
            }
            .admin-profil{
                display: flex;
                flex-direction: row;
                align-items: center;
            }
            .admin-profil img{
                width : 80px;
                margin-right: 20px;
                object-fit: contain;
                border-radius: 50%;
            }
            .logout{
                position: absolute;
                bottom: 20px;
            }

        </style>
    @endrole
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @role('admin')
        @include('layouts.navigationAdmin')
    @elserole('customer')
        @include('layouts.navigationCust')
    @endrole

    <main class="content">
        @yield('content')
    </main>

    @include('layouts.footer')
    @yield('scripts')
</body>
</html>