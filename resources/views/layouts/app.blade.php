<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('images/big-warna.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>BIG Store</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Data Tables -->
    <link rel='stylesheet' href='https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css'>

    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='{{asset('fontawesome-free-6.5.2-web/css/all.min.css')}}'>

    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <link href="{{ asset('build/assets/argon-dashboard-bef17899.css') }}" rel="stylesheet" /> --}}
    {{-- <link rel="stylesheet" href="resources/scss/argon-dashboard.scss">
    <script src="resources/js/app.js"></script> --}}
    @vite(['resources/scss/argon-dashboard.scss', 'resources/js/app.js'])
    <style>
        .navbar-vertical.navbar-expand-xs .navbar-collapse {
            height: calc(100% - 32px - 24px - 24px - 1px) !important;
        }
    </style>
    @stack('css')
</head>

<body class="{{ $class ?? '' }}">
    {{-- @guest --}}
        {{-- @yield('content') --}}
    {{-- @endguest --}}
    {{-- @auth --}}

    <div class="min-height-300 bg-danger position-fixed top-0 w-100"></div>

    <div class="position-relative overflow-hidden d-flex vh-100 w-100">
        @include('layouts.navbars.sidenav')
        <main class="position-relative main-content overflow-auto w-100">
            @yield('content')
            @include('layouts.footers.footer')
        </main>

    </div>
    <button id="btn-to-top"
        class="btn btn-dark position-fixed opacity-5 d-flex align-items-center justify-content-center"
        style="z-index: 100; bottom: -6rem;right: 4rem;width: 3rem;height: 3rem;"><i
            class="fa-solid fa-chevron-up"></i></button>
    {{-- @endauth --}}
    @stack('modal')

    {{-- <script src="{{ asset('build/assets/app-dca2c067.js ') }}"></script> --}}

    @stack('js')
    <!-- jQuery -->
    <script src='https://code.jquery.com/jquery-3.7.0.js'></script>
    <!-- Data Table JS -->
    <script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
    <script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>
</body>

</html>
