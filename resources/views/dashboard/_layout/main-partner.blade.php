<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>@yield('title') | Mitra ABDSI Sistem Satu Data Pendamping KUMKM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Tailwind Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <meta name="base-url" content="{{ url('/') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/abdsi-icon.png') }}">
    <!-- Layout config Js -->
    <!-- Icons CSS -->


    <!-- Tailwind CSS -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    {{-- <link rel="stylesheet" href="{{ asset('assets/css/tailwind2.css') }}"> --}}
</head>

<body data-mode="light" class="group text-gray-600">

    <!-- Left Sidebar Start -->
    @include('dashboard._layout.sidebar-partner')
    <!-- Left Sidebar End -->

    <!-- Navbar Start -->
    @include('dashboard._layout.navbar-partner')
    <!-- Navbar End -->

    <div class="main-content mt-24">
        <div class="min-h-screen page-content ml-64">

            <div class="container-fluid text-xs min-h-full">

                <!-- Content Start -->
                @yield('content')
                <!-- Content End -->

                <!-- Footer Start -->
                @include('dashboard._layout.footer')
                <!-- Footer End -->
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/libs/popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/libs/metismenujs/metismenujs.min.js') }}"></script>
    <script src="{{ asset('assets/js/libs/simplebar/simplebar.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
