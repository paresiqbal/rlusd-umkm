@php
    $isLogin = true;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Metadata Link & Title --}}
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}" />
    <link rel="icon" href="{{ asset('assets/img/rlusd-icon.png') }}" type="image/png">
    <title> @yield('title') | rlusd Sistem Pendamping UMKM </title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    {{-- Styling --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="text-base antialiased font-normal text-gray-800 transition-all duration-200">

    <div class="flex h-screen overflow-hidden bg-stone-50">
        <!-- Sidebar -->
        @include('admin._layout.sidebar')

        <div class="flex flex-col w-full">
            <!-- Navbar -->
            @include('admin._layout.navbar')

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-4 w-full">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('admin._layout.footer')
        </div>
    </div>

    {{-- JS --}}
    <script src="{{ asset('assets/js/libs/popperjs/popper.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @include('common._component.global-notyf')
    @stack('scripts')
</body>

</html>
