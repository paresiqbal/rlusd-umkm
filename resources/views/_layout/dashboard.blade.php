<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Sistem Satu Data Pendamping | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Tailwind Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/abdsi-icon.png') }}">
    <!-- Layout config Js -->
    <!-- Icons CSS -->


    <!-- Tailwind CSS -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <link rel="stylesheet" href="{{ asset('assets/css/tailwind2.css') }}">
</head>

<body data-mode="light" class="group text-gray-600">

    <!-- ========== Left Sidebar Start ========== -->
    @include('_component.dashboard.partner.sidebar')
    <!-- Left Sidebar End -->

    @php
        $user = Auth::user();
        $role = $user->role;
        $routeLogout = match ($role->role_name) {
            'admin' => route('admin.auth.logout'),
            default => route('users.auth.logout'),
        };
    @endphp

    <nav class="fixed top-0 left-0 right-0 z-20 flex items-center bg-white print:hidden pr-6">

        <div class="flex justify-between w-full">
            <div class="flex items-center topbar-brand">
                <div
                    class="hidden lg:flex navbar-brand items-center justify-between shrink px-6 h-[70px]  border-r bg-[#fbfaff] border-gray-50 shadow-none">
                    <a href="#" class="flex items-center text-lg flex-shrink-0 font-bold leading-[69px]">
                        <img src="{{ asset('assets/img/abdsi-icon.png') }}" alt=""
                            class="inline-block w-6 h-6 align-middle xl:mr-2">
                        <span class="hidden font-bold text-gray-700 align-middle xl:block leading-[69px]">SSDP
                            KUMKM</span>
                    </a>
                </div>
                <button type="button"
                    class="group-data-[sidebar-size=sm]:border-b border-b border-[#e9e9ef] lg:border-transparent  group-data-[sidebar-size=sm]:border-[#e9e9ef] text-gray-800 h-[70px] px-4 -ml-[52px] py-1 vertical-menu-btn text-16"
                    id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>

            </div>
            <div class="flex justify-end w-full items-center border-b border-[#e9e9ef] pl-6">

                <div class="flex">
                    <div>
                        <div class="relative block dropdown sm:hidden">
                            <button type="button" class="text-xl px-4 h-[70px] text-gray-600 dropdown-toggle"
                                data-dropdown-toggle="navNotifications">
                                <i data-feather="search" class="w-5 h-5"></i>
                            </button>

                            <div class="absolute top-0 z-50 hidden px-4 mx-4 list-none bg-white border rounded shadow  dropdown-menu -left-36 w-72 border-gray-50"
                                id="navNotifications">
                                <form class="py-3 dropdown-item" aria-labelledby="navNotifications">
                                    <div class="m-0 form-group">
                                        <div class="flex w-full">
                                            <input type="text" class="border-gray-100 w-fit" placeholder="Search ..."
                                                aria-label="Search Result">
                                            <button
                                                class="text-white border-l-0 border-transparent rounded-l-none btn btn-primary bg-violet-500"
                                                type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative dropdown">
                            <button type="button"
                                class="flex items-center px-3 py-2 h-[70px] border-x border-gray-50 bg-gray-50/30  dropdown-toggle"
                                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="true">
                                <img class="border-[3px] border-gray-700 rounded-full w-9 h-9 xl:mr-2"
                                    src="https://i.pravatar.cc/300" alt="Header Avatar">
                                <span class="hidden font-medium xl:block">Shawn L.</span>
                                <i class="hidden align-bottom mdi mdi-chevron-down xl:block"></i>
                            </button>
                            <div class="absolute top-0 z-50 hidden w-40 list-none bg-white dropdown-menu dropdown-animation rounded shadow "
                                id="profile/log">
                                <div class="border border-gray-50 " aria-labelledby="navNotifications">
                                    <div class="dropdown-item">
                                        <a class="block px-3 py-2 hover:bg-gray-50/50"
                                            href="apps-contacts-profile.html">
                                            <i class="mr-1 align-middle mdi mdi-face-man text-16"></i> Akun
                                        </a>
                                    </div>
                                    <hr class="border-gray-50">
                                    <div class="dropdown-item">
                                        <a class="block px-3 py-2 hover:bg-gray-50/50" href="{{ $routeLogout }}">
                                            <i class="mr-1 align-middle mdi mdi-logout text-16"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div class="main-content group-data-[sidebar-size=sm]:ml-[70px]">
        <div class="min-h-screen page-content">

            <div class="container-fluid px-[0.625rem]">
                <div class="grid grid-cols-1 pb-6">
                    <div class="md:flex items-center justify-between px-[2px]">
                        <h4 class="text-[18px] font-medium text-gray-800 mb-sm-0 grow mb-2 md:mb-0">@yield('title')
                        </h4>
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="{{ route('partners.dashboard') }}"
                                        class="inline-flex items-center text-sm text-gray-800 hover:text-gray-900">
                                        Mitra
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <i
                                            class="font-semibold text-gray-600 align-middle far fa-angle-right text-13"></i>
                                        <a href="{{ url()->current() }}"
                                            class="text-sm font-medium text-gray-500 ml-2 hover:text-gray-900 md:ml-2">@yield('title')</a>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                @yield('content')

                <!-- Footer Start -->
                <footer class="absolute left-0 right-0 px-5 py-5 bg-white border-t footer border-gray-50">
                    <div class="grid grid-cols-2 text-gray-500">
                        <div class="grow">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Minia
                        </div>
                        <div class="hidden md:inline-block text-end">Design & Develop by <a href=""
                                class="underline text-violet-500">Themesbrand</a></div>

                    </div>
                </footer>
                <!-- end Footer -->
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
