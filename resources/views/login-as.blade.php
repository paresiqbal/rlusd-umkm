@extends(env('APP_ENV') == 'production' ? 'common._layout.main-login-as-prod' : 'common._layout.main-no-option')

@section('title', 'Login Sebagai')

@section('content')
    <div class="flex flex-col justify-center items-center min-h-[50vh] gap-8 px-8">
        <div class="flex flex-col justify-center w-full lg:w-1/2 text-center">
            <h2 class="text-2xl font-bold">Selamat Datang Kembali</h2>
            <p class="text-gray-500">Pilih peran login Anda:</p>
        </div>
        <div class="flex flex-col lg:flex-row justify-center w-full gap-6">
            <div class="flex flex-col items-center justify-center gap-4 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" width="128" height="128" stroke-width="1">
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855"></path>
                </svg>
                <div class="flex gap-2">
                    <p>Konsultan</p>
                    <img src="/assets/icons/info.svg" alt="info">
                </div>
                <a class="btn-primary" href="{{ route('users.auth.login.index') }}">Login Sebagai Konsultan</a>
            </div>
            <div class="flex flex-col items-center justify-center gap-4 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" width="128" height="128" stroke-width="1">
                    <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15"></path>
                    <path d="M16 8h2c1 0 2 1 2 2v11"></path>
                    <path d="M3 21h18"></path>
                    <path d="M10 12v0"></path>
                    <path d="M10 16v0"></path>
                    <path d="M10 8v0"></path>
                    <path d="M7 12v0"></path>
                    <path d="M7 16v0"></path>
                    <path d="M7 8v0"></path>
                    <path d="M17 12v0"></path>
                    <path d="M17 16v0"></path>
                </svg>
                <div class="flex gap-2">
                    <p>Mitra</p>
                    <img src="/assets/icons/info.svg" alt="info">
                </div>
                <a class="btn-primary bg-green-500 px-8" href="{{ route('partners.auth.login.index') }}">Login
                    Sebagai
                    Mitra</a>
            </div>
            <div class="flex-col items-center justify-center gap-4 text-gray-500 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-linecap="round" stroke-linejoin="round" width="128" height="128" stroke-width="1">
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5"></path>
                    <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                    <path d="M19.001 15.5v1.5"></path>
                    <path d="M19.001 21v1.5"></path>
                    <path d="M22.032 17.25l-1.299 .75"></path>
                    <path d="M17.27 20l-1.3 .75"></path>
                    <path d="M15.97 17.25l1.3 .75"></path>
                    <path d="M20.733 20l1.3 .75"></path>
                </svg>
                <a class="btn-primary" href="{{ route('admin.auth.login.index') }}">Masuk Sebagai Admin</a>
            </div>
        </div>
    </div>
@endsection
