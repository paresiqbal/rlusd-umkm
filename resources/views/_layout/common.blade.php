@php
    $isLogin = true;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- font --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" href="{{ asset('assets/img/rlusd.png') }}" type="image/png">
    <title>RLUSD Sistem Pendamping UMKM Rejang Lebong | @yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="text-base antialiased font-normal text-gray-800 transition-all duration-200">
    <header class="fixed flex flex-row items-center justify-between w-full px-8 py-4 bg-white md:px-16">
        <div class="flex items-center gap-16">
            <a href="#">
                <img class="h-6" src="{{ asset('assets/img/rlusd.png') }}" alt="logo">
            </a>
            <ul class="hidden gap-8 md:flex">
                <li>
                    <a class="hover:text-gray-900" href="#">Anda Butuh Konsultan?</a>
                </li>
                <li>
                    <a class="hover:text-gray-900" href="#">Peluang</a>
                </li>
            </ul>
        </div>

        {{-- <div class="flex gap-4">
                <a class="btn-outlined" href="#">
                    Masuk
                </a>
                <a class="btn-primary" href="#">
                    Daftar
                </a>
            </div> --}}
        <div class="relative flex items-center gap-4 text-sm font-medium cursor-pointer group/avatar">
            <img class="h-6 rounded-full" src="https://i.pravatar.cc/300" alt="avatar">
            Joni Ahayy
            <div class="absolute z-50 hidden w-40 list-none bg-white rounded-lg shadow group-hover/avatar:block top-full dropdown-menu dropdown-canimation"
                id="profile/log" data-popper-placement="bottom-start">
                <div class="border rounded-lg border-gray-50 " aria-labelledby="navNotifications">
                    <div class="dropdown-item">
                        <a class="block px-3 py-2 hover:bg-gray-50/50" href="apps-contacts-profile.html">
                            Profile
                        </a>
                    </div>
                    <hr class="border-gray-50">
                    <div class="dropdown-item">
                        <a class="block px-3 py-2 hover:bg-gray-50/50" href="apps-contacts-profile.html">
                            Keluar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <main class="container px-8 pt-24 mx-auto md:px-16">
        @yield('content')
    </main>

    @include('common._layout.footer-user')

    <script src="{{ asset('assets/js/libs/popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/libs/metismenujs/metismenujs.min.js') }}"></script>
    <script src="{{ asset('assets/js/libs/simplebar/simplebar.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>


    @stack('scripts')
</body>

</html>
