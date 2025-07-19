@php
    $user = Auth::user();
    $role = $user->role;
    $routeLogout = match ($role->role_name) {
        'admin' => route('admin.auth.logout'),
        default => route('users.auth.logout'),
    };
@endphp


<nav class="fixed top-0 left-0 right-0 z-20 flex items-center bg-white  pr-6">

    <div class="flex justify-between w-full">
        <div class="flex items-center topbar-brand transition-all shrink-0 w-64">
            <div
                class="w-full navbar-brand items-center justify-between shrink px-6 h-[70px] border-r bg-[#fbfaff] border-gray-50 shadow-none">
                <a href="#" class="flex items-center text-lg flex-shrink-0 font-bold leading-[69px] gap-2">
                    <img src="{{ asset('assets/img/rlusd.png') }}" alt=""
                        class="inline-block w-6 h-6 align-middle shrink-0">
                    <span class="font-bold text-gray-700 align-middle xl:block leading-[69px]">SSDP KUMKM</span>
                </a>
            </div>
        </div>
        <div class="flex justify-end w-full items-center border-b border-[#e9e9ef] pl-6">

            <div class="flex items-center justify-between w-full">
                <div>
                    <button onclick="sidebarToggle(this)" data-target="sidebar-toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 6l16 0" />
                            <path d="M4 12l16 0" />
                            <path d="M4 18l16 0" />
                        </svg>
                    </button>
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
                        <div class="absolute top-0 z-50 hidden w-40 list-none bg-white dropdown-menu dropdown-animation rounded shadow"
                            id="profile/log">
                            <div class="border border-gray-50 " aria-labelledby="navNotifications">
                                <div class="dropdown-item">
                                    <a class="flex items-center gap-4 px-3 py-2 hover:bg-gray-50/50"
                                        href="apps-contacts-profile.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        </svg>
                                        Akun
                                    </a>
                                </div>
                                <hr class="border-gray-50">
                                <div class="dropdown-item">
                                    <form action="{{ $routeLogout }}" method="POST">
                                        @csrf
                                        <button
                                            class="flex items-center gap-4 px-3 py-2 hover:bg-gray-50/50 w-full text-left"
                                            href="{{ $routeLogout }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                                <path d="M15 12h-12l3 -3" />
                                                <path d="M6 15l-3 -3" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
