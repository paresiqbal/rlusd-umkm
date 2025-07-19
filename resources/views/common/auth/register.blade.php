@extends('common._layout.main-user')

@section('content')
    <div class="flex flex-col justify-between h-full gap-32 px-8 lg:flex-row">
        <div class="flex flex-col justify-center w-full gap-5 lg:w-1/2">
            @if (session('errorAlert'))
                <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        {{ session('errorAlert') }}
                    </div>
                </div>
            @elseif (session('successAlert'))
                <div class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50"
                    role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        {{ session('successAlert') }}
                    </div>
                </div>
            @endif
            <div class="flex flex-col gap-1">
                <h2 class="text-2xl font-bold">Buat Akun</h2>
                <p class="font-medium text-gray-500">Sudah punya akun? <a href="@yield('urlRedirectLogin')" class="link">Login
                        disini.</a>
                </p>
            </div>
            <a href="@yield('urlRedirectGoogle')" class="flex items-center justify-center gap-2 font-medium btn-google-auth"><img
                    src="/assets/img/google-icon.png"><span>Mendaftar dengan Google</span></a>
            <div class="text-gray-200 divider"><span>Atau</span></div>
            <form method="POST" action="@yield('urlRegisterPost')" class="flex flex-col gap-5">
                @csrf
                <div>
                    <label for="name" class="block mb-2 font-medium text-gray-700">
                        @sectionMissing("fieldLabelName")
                            Nama
                        @endif
                        @hasSection('fieldLabelName')
                            @yield('fieldLabelName')
                        @endif
                    </label>
                    <input
                        class="w-full placeholder:text-13 text-13 py-1.5 rounded border-gray-100 focus:border focus:border-violet-50 focus:ring focus:ring-violet-500/20  placeholder:text-gray-500"
                        type="text" placeholder="e.g. John Doe" name="name" id="name">
                    @error('name')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 font-medium text-gray-700 ">Email</label>
                    <input
                        class="w-full placeholder:text-13 text-13 py-1.5 rounded border-gray-100 focus:border focus:border-violet-50 focus:ring focus:ring-violet-500/20  placeholder:text-gray-500"
                        type="email" placeholder="pakvincent@orang-dua.com" name="email" id="email">
                    @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block mb-2 font-medium text-gray-700 ">Password</label>
                    <input
                        class="w-full placeholder:text-13 text-13 py-1.5 rounded border-gray-100 focus:border focus:border-violet-50 focus:ring focus:ring-violet-500/20  placeholder:text-gray-500"
                        type="password" placeholder="minimum 8 characters" name="password" id="password">
                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex items-start gap-3">
                    <input type="checkbox"
                        class="align-middle rounded cursor-pointer focus:border-violet-100 focus:ring focus:ring-violet-500/20 focus:ring-offset-0"
                        id="formrow-customCheck">
                    <label for="approve-terms-policy" class="text-gray-500">
                        Dengan mendaftar, Anda membuat akun dan menyetujui <a href="#" class="link">Ketentuan
                            Penggunaan</a>
                        serta <a href="#" class="link">Kebijakan Privasi</a> ABDSI.
                    </label>
                </div>
                <button class="font-normal btn-primary">Daftar</button>
            </form>
        </div>
        <div class="items-center hidden w-full lg:flex lg:w-1/2">
            <img src="/assets/img/auth-illustration.png" alt="Login image">
        </div>
    </div>
@endsection
