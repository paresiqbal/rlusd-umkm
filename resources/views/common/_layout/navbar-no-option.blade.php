<header class="fixed flex flex-row items-center justify-between w-full px-6 py-4 bg-white md:px-16">
    {{-- NAVBAR - START --}}
    <div class="items-center gap-16 flex ">
        <a href="#">
            <img class="h-6"
                src="{{ env('APP_ENV') == 'production' ? 'https://freelancer.pendampingkumkm.id/assets/img/abdsi-logo.png' : asset('assets/img/abdsi-logo.png') }}"
                alt="logo">
        </a>
    </div>
    {{-- NAVBAR - END --}}

    {{-- NAVBAR MOBILE - START --}}
    {{-- <div class="flex items-center gap-4 md:hidden">
        <div role="button" class="p-2" data-drawer-target="drawer-sidebar" data-drawer-show="drawer-sidebar"
            aria-controls="drawer-sidebar">
            <i class="text-xl ti ti-baseline-density-medium"></i>
        </div>
        <a href="#">
            <img class="h-6" src="{{ asset('assets/img/abdsi-logo.png') }}" alt="logo">
        </a>
    </div> --}}
    {{-- NAVBAR MOBILE - END --}}

    {{-- USER PROFILE - START --}}
    @auth
        @php
            $user = Auth::user();
            $role = $user->role;
            $routeLogout = match ($role->role_name) {
                'admin' => route('admin.auth.logout'),
                'partner' => route('partners.auth.logout'),
                default => route('users.auth.logout'),
            };
        @endphp
        <div class="relative flex items-center gap-4 text-sm font-medium cursor-pointer group/avatar">
            <img class="h-6 rounded-full" src="https://i.pravatar.cc/300" alt="avatar">
            {{ $user->profile->name }}
            <div class="absolute top-full right-0 z-50 hidden w-40 list-none rounded-lg  group-hover/avatar:block dropdown-menu dropdown-canimation"
                id="profile/log" data-popper-placement="bottom-start">
                <div class="pt-3">
                    <div class="shadow border rounded bg-white border-gray-50" aria-labelledby="navNotifications">
                        <div class="dropdown-item ">
                            <a class="block px-3 py-2 hover:bg-gray-50/50 " href="apps-contacts-profile.html">
                                Profile
                            </a>
                        </div>
                        <hr class="border-gray-50 ">
                        <div class="dropdown-item ">
                            <form action="{{ $routeLogout }}" method="POST">
                                @csrf
                                <button class="block px-3 py-2 w-full text-start hover:bg-gray-50/50 ">
                                    Keluar
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endauth
    {{-- USER PROFILE - END --}}

</header>

{{-- SIDEBAR - START --}}
{{-- <div id="drawer-sidebar"
    class="fixed top-0 left-0 z-50 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-navigation-label">
    <a id="drawer-sidebar-label" href="#">
        <img class="h-6 px-4" src="{{ asset('assets/img/abdsi-logo.png') }}" alt="logo">
    </a>
    <button type="button" data-drawer-hide="drawer-sidebar" aria-controls="drawer-sidebar"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <i class="text-lg ti ti-x"></i>
        <span class="sr-only">Close menu</span>
    </button>

</div> --}}
{{-- SIDEBAR - END --}}
