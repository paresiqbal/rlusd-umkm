@extends('partner._layout.main')

@section('title', 'Mitra Dashboard')

@section('content')
    <div class="flex flex-col flex-1 w-full overflow-x-hidden">
        <h2 class="py-3 text-2xl">Profil Perusahaan</h2>
        <div>
            <div class="p-6 bg-white rounded-md">
                <div class="flex items-center justify-between pb-4">
                    <div class="flex items-center gap-4 font-semibold text-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        Data Perusahaan
                    </div>
                    <button class="btn-secondary" id="edit-profile-btn">Edit</button>
                </div>
                <div class="flex items-center gap-4 change-avatar">
                    <img class="rounded-full size-16"
                        src="{{ $userPhotoProfile ?? asset('assets/img/default-avatar.jpg') }}" alt="profile-picture"
                        id="profile-picture-image">
                    <div class="flex gap-4">
                        <form action="/" method="POST">
                            <input data-tw-target="#partner-profile-picture-modal" accept="image/jpeg, image/png"
                                type="file" class="hidden" id="input-profile-picture"
                                onchange="onProfilePictureFileChanged(this)">
                            <input type="submit" class="hidden" id="btn-profile-picture-submit">
                        </form>
                        <button class="btn-secondary" onclick="onProfilePictureButtonClick(this)">
                            Logo Instansi
                        </button>
                        <form action="{{ route('partners.profile.delete-photo') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div
                    class="flex flex-col flex-wrap gap-4 mt-4 font-medium md:flex-row md:gap-0 md:gap-y-6 [&>div]:space-y-2">
                    <div class="md:basis-1/3">
                        <label class="text-sm text-gray-500">Perusahaan</label>
                        <p>{{ $partner->partner_name }}</p>
                    </div>
                    <div class="md:basis-1/3">
                        <label class="text-sm text-gray-500">Email</label>
                        <p>{{ $user->email ?? '-' }}</p>
                    </div>
                    <div class="md:basis-1/3">
                        <label class="text-sm text-gray-500">Alamat</label>
                        <p>{{ $partner->address ?? '-' }}</p>
                    </div>
                    <div class="md:basis-1/3">
                        <label class="text-sm text-gray-500">Phone</label>
                        <p>{{ $partner->phone_number ?? '-' }}</p>
                    </div>
                    <div class="md:basis-1/3">
                        <label class="text-sm text-gray-500">Kode Pos</label>
                        <p>{{ $partner->postal_code ?? '-' }}</p>
                    </div>
                    <div class="md:basis-1/3">
                        <label class="text-sm text-gray-500">Organisasi</label>
                        <p>{{ $partner->organization?->organization_name ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col p-6 mt-4 bg-white rounded-md">
                <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                    <div class="flex items-center gap-2 mb-4 sm:gap-6 sm:mb-0">
                        <img src="{{ asset('/assets/icons/profile/borger.svg') }}" alt="borger" class="w-6 h-6" />
                        <p class="text-lg font-semibold text-gray-700 sm:text-base">Tentang Perusahaan</p>
                    </div>
                    <div class="flex gap-2 mt-4 sm:gap-4 sm:mt-0">
                        @if (empty($partner->about_company))
                            <button class="btn-primary-outlined" id="edit-about-company">Tambah Tentang Perusahaan</button>
                        @else
                            <button class="btn-secondary" id="edit-about-company">Edit</button>
                        @endif
                    </div>
                </div>
                <div class="mt-4 text-justify">
                    <p>{{ $partner->about_company }}</p>
                </div>
            </div>

            <div class="flex flex-col p-6 mt-4 bg-white rounded-md">
                <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                    <div class="flex items-center gap-2 mb-4 sm:gap-6 sm:mb-0">
                        <img src="{{ asset('/assets/icons/profile/borger.svg') }}" alt="borger" class="w-6 h-6" />
                        <p class="text-lg font-semibold text-gray-700 sm:text-base">Narahubung Mitra</p>
                    </div>
                    <div class="flex gap-2 mt-4 sm:gap-4 sm:mt-0">
                        @if (empty($partner->pic_name))
                            <button class="btn-primary-outlined" id="edit-about-pic">Tambah Narahubung Mitra</button>
                        @else
                            <button class="btn-secondary" id="edit-about-pic">Edit</button>
                        @endif
                    </div>
                </div>
                <div class="mt-4 text-justify">
                    <p class="text-lg font-bold">{{ $partner->pic_name }}</p>
                    <div class="flex items-center gap-8 mt-2">
                        <p>{{ $partner->pic_email }}</p>
                        <p>{{ $partner->pic_phone_number }}</p>
                        <p>{{ $partner->pic_position }}</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col p-6 mt-4 bg-white rounded-md">
                <div class="flex flex-col items-start justify-between sm:flex-row sm:items-center">
                    <div class="flex items-center gap-2 mb-4 sm:gap-6 sm:mb-0">
                        <img src="{{ asset('/assets/icons/profile/borger.svg') }}" alt="borger" class="w-6 h-6" />
                        <p class="text-lg font-semibold text-gray-700 sm:text-base">Website Perusahaan</p>
                    </div>
                    <div class="flex gap-2 mt-4 sm:gap-4 sm:mt-0">
                        @if (empty($partner->website))
                            <button class="btn-primary-outlined" id="edit-about-website">Tambah Website
                                Perusahaan</button>
                        @else
                            <button class="btn-secondary" id="edit-about-website">Edit</button>
                        @endif
                    </div>
                </div>
                <div class="mt-4 text-justify">
                    <p class="text-lg font-bold">{{ $partner->website }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- include modals -->
    @include('partner.profiles._components.personal-data')
    @include('partner.profiles._components.about-company')
    @include('partner.profiles._components.pic-data')
    @include('partner.profiles._components.website')

    @include('partner.profiles._components.photo-profile', [
        'inputId' => 'input-profile-picture',
        'modalId' => 'partner-profile-picture-modal',
    ])
@endsection

@push('scripts')
    @vite(['resources/js/partners/profiles/edit-profile.js', 'resources/js/partners/profiles/edit-about.js', 'resources/js/partners/profiles/edit-pic.js', 'resources/js/partners/profiles/edit-website.js'])
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash
            if (hash) {
                document.querySelector(`[data-tw-target="${hash}"]`)?.click()
            }
        });
    </script>
@endpush
