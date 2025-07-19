@auth
    @php
        $user = Auth::user();
        $profile = $user->profile()->first();
        $profileName = $profile ? $profile->name : 'Administrator';
        $role = $user->role;
        $routeLogout = match ($role->role_name) {
            'admin' => route('admin.auth.logout'),
            default => route('users.auth.logout'),
        };
    @endphp
    <nav class="bg-primary-500 p-4 px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center ">
            <p class="hidden sm:block text-white">{{ $pageTitle ?? 'Dashboard' }}</p>
            <div class="relative flex items-center gap-4 text-sm font-medium cursor-pointer group/avatar ml-auto">
                <img class="h-6 rounded-full" src="/assets/img/default-avatar.jpg" alt="avatar">
                {{ $profileName }}
                <div class="absolute top-full right-0 z-50 hidden w-40 list-none rounded-lg group-hover/avatar:block dropdown-menu dropdown-canimation"
                    id="profile/log" data-popper-placement="bottom-start">
                    <div class="pt-3">
                        <div class="shadow border rounded bg-white border-gray-50" aria-labelledby="navNotifications">
                            <hr class="border-gray-50">
                            <div class="dropdown-item">
                                <form method="POST" action="{{ $routeLogout }}">
                                    @csrf
                                    <button class="block px-3 py-2 w-full text-start hover:bg-gray-50/50">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endauth
