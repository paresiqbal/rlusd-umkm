<header class="fixed flex flex-row items-center justify-between w-full px-6 py-4 bg-white md:px-16">
    {{-- NAVBAR - START --}}
    <div class="items-center hidden gap-16 md:flex ">
        <a href="https://pendampingkumkm.id/" class="flex items-center gap-2 font-semibold text-xl text-gray-900">
            <img class="h-12" src="{{ asset('assets/img/rlusd.png') }}" alt="logo">
            <p>RLUSD</p>
        </a>
        <ul class="flex gap-8 font-medium">
            <li>
                @if (Route::currentRouteName() === 'users.auth.login.index' ||
                        (Auth::check() && Auth::user()->role->role_name === 'freelancer'))
                    <a class="text-gray-900 hover:text-primary-500" href="{{ route('partners.auth.login.index') }}">Anda
                        Butuh Konsultan?</a>
                @elseif (Route::currentRouteName() === 'admin.auth.login.index')
                    <a class="text-gray-900 hover:text-primary-500" href="{{ route('admin.auth.login.index') }}">Lihat
                        Daftar Mitra</a>
                @else
                    <a class="text-gray-900 hover:text-primary-500" href="{{ route('users.auth.login.index') }}">Anda
                        Konsultan?</a>
                @endif
            </li>
            <li>
                @if (Route::currentRouteName() === 'users.auth.login.index' ||
                        (Auth::check() && Auth::user()->role->role_name === 'freelancer'))
                    <a class="text-gray-900 hover:text-primary-500"
                        href="{{ route('users.jobs.index-search') }}">Peluang</a>
                @elseif (Route::currentRouteName() === 'admin.auth.login.index')
                    <a class="text-gray-900 hover:text-primary-500" href="{{ route('admin.auth.login.index') }}">Lihat
                        Daftar Konsultan</a>
                @else
                    <a class="text-gray-900 hover:text-primary-500"
                        href="{{ route('partners.auth.login.index') }}">Lihat
                        Daftar Konsultan</a>
                @endif

            </li>
        </ul>
    </div>
    {{-- NAVBAR - END --}}

    {{-- NAVBAR MOBILE - START --}}
    <div class="flex items-center gap-4 md:hidden">
        <div role="button" class="p-2" data-drawer-target="drawer-sidebar" data-drawer-show="drawer-sidebar"
            aria-controls="drawer-sidebar">
            <i class="text-xl ti ti-baseline-density-medium"></i>
        </div>
        <a href="https://pendampingkumkm.id/">
            <img class="h-6" src="{{ asset('assets/img/abdsi-logo.png') }}" alt="logo">
        </a>
    </div>
    {{-- NAVBAR MOBILE - END --}}

    {{-- USER PROFILE - START --}}
    @auth
        @php
            $user = Auth::user();
            $role = $user->role;
            $profile = $user->profile;
            $routeLogout = match ($role->role_name) {
                'admin' => route('admin.auth.logout'),
                default => route('users.auth.logout'),
            };

            // Ensure the photo profile URL is absolute
            $userPhotoProfile = $profile->photoFile
                ? $profile->photoFile->public_url
                : asset('assets/img/default-avatar.jpg');
        @endphp
        <div class="relative flex items-center gap-4 text-sm font-medium cursor-pointer group/avatar">
            <img class="h-6 rounded-full" src="{{ $userPhotoProfile }}" alt="avatar">
            {{ $user->profile->name }}
            <div class="absolute top-full right-0 z-50 hidden w-40 list-none rounded-lg  group-hover/avatar:block dropdown-menu dropdown-canimation"
                id="profile/log" data-popper-placement="bottom-start">
                <div class="pt-3">
                    <div class="shadow border rounded bg-white border-gray-50" aria-labelledby="navNotifications">
                        <div class="dropdown-item ">
                            <a class="block px-3 py-2 hover:bg-gray-50/50" href="{{ route('users.profiles.show') }}">
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
<div id="drawer-sidebar"
    class="fixed top-0 left-0 z-50 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-navigation-label">
    <a id="drawer-sidebar-label" href="https://pendampingkumkm.id/">
        <img class="h-6 px-4" src="{{ asset('assets/img/rlusd.png') }}" alt="logo">
    </a>
    <button type="button" data-drawer-hide="drawer-sidebar" aria-controls="drawer-sidebar"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <i class="text-lg ti ti-x"></i>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="py-6 overflow-y-auto ">
        <ul class="font-medium ">
            <li>
                <a href="{{ route('partners.auth.login.index') }}"
                    class="flex items-center p-4 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span>Anda Butuh Konsultan?</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.jobs.index-search') }}"
                    class="flex items-center p-4 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <span>Lihat Daftar Peluang</span>
                </a>
            </li>
        </ul>
    </div>
</div>
{{-- SIDEBAR - END --}}
