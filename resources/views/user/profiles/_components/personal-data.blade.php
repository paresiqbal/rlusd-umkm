<section>
    <div id="data-diri" class="tab-pane active">
        <div class="[&>div]:bg-white [&>div]:rounded-lg [&>div]:border-0">
            <div>
                @if (Session::has('globalToast'))
                    @php
                        $session = Session::get('globalToast');
                    @endphp

                    @if ($session['type'] == 'success')
                        <div class="w-full p-4 my-2 text-green-500 rounded bg-green-50">
                            {{ $session['message'] }}
                        </div>
                    @endif
                @endif

                <div class="[&>div]:bg-white [&>div]:rounded-lg [&>div]:border-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                    Data Diri
                                </div>
                                <div>
                                    <button onclick="openModal(this)" data-tw-toggle="modal"
                                        data-tw-target="#user-profile-personal-data" class="btn-secondary">Edit</button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center gap-4 change-avatar">
                                    <img class="rounded-full size-16"
                                        src="{{ $userPhotoProfile ?? asset('assets/img/default-avatar.jpg') }}"
                                        alt="profile-picture" id="profile-picture-image">
                                    <div class="flex gap-4">
                                        <form action="/" method="POST">
                                            <input data-tw-target="#user-profile-picture-modal"
                                                accept="image/jpeg, image/png" type="file" class="hidden"
                                                id="input-profile-picture" onchange="onProfilePictureFileChanged(this)">
                                            <input type="submit" class="hidden" id="btn-profile-picture-submit">
                                        </form>
                                        <button class="btn-secondary" onclick="onProfilePictureButtonClick(this)">
                                            Unggah Foto Baru
                                        </button>
                                        <button class="btn-icon" data-tw-toggle="modal"
                                            data-tw-target="#delete-confirmation-modal"
                                            onclick="openDeleteModal(this, '{{ route('users.profiles.delete-photo') }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-col flex-wrap gap-4 mt-4 font-medium md:flex-row md:gap-0 md:gap-y-6 [&>div]:space-y-2">
                                    <div class="md:basis-1/3 ">
                                        <label for="name" class="text-sm text-gray-500">Nama</label>
                                        <p>{{ $user->profile->name ?? '-' }}</p>
                                    </div>
                                    <div class="md:basis-1/3">
                                        <label for="email" class="text-sm text-gray-500">Email</label>
                                        <p>{{ $user->email ?? '-' }}</p>
                                    </div>
                                    <div class="md:basis-1/3">
                                        <label for="address" class="text-sm text-gray-500">Alamat</label>
                                        <p>{{ $user->profile->address ?? '-' }}</p>
                                    </div>
                                    <div class="md:basis-1/3">
                                        <label for="age-gender" class="text-sm text-gray-500">Usia, Jenis
                                            Kelamin</label>
                                        @if (empty($user->profile->age) && empty($user->profile->gender))
                                            <p>-</p>
                                        @else
                                            <p>{{ $user->age }},
                                                @if ($user->profile->gender === 1)
                                                    Laki-Laki
                                                @elseif ($user->profile->gender === 2)
                                                    Perempuan
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                    <div class="md:basis-1/3">
                                        <label for="wa" class="text-sm text-gray-500">Nomor WA</label>
                                        <p>{{ $user->profile->phone_number ?? '-' }}</p>
                                    </div>
                                    <div class="md:basis-1/3">
                                        <label for="postal_code" class="text-sm text-gray-500">Kode Pos</label>
                                        <p>{{ $user->profile->postal_code ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center justify-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-align-justified">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 6l16 0" />
                                        <path d="M4 12l16 0" />
                                        <path d="M4 18l12 0" />
                                    </svg>
                                    Tentang Saya
                                </div>
                                <div>
                                    @if ($user->profile->about_me != null)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-about-me" class="btn-secondary">Edit</button>
                                    @else
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-about-me"
                                            class="btn-primary-outlined">Tambah
                                            Tentang
                                            Saya</button>
                                    @endif
                                </div>
                            </div>
                            @if ($user->profile->about_me != null)
                                <div class="mt-4 text-justify">
                                    {{ $user->profile->about_me }}
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                    </svg>
                                    Riwayat Pendidikan
                                </div>
                                <div class="flex gap-4">
                                    @if (count($user->profile->educations) > 0)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-education-edit"
                                            class="btn-secondary">Edit</button>
                                    @else
                                        <button onclick="openAddModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-education-form"
                                            data-action="{{ route('users.profiles.educations.store') }}"
                                            class="btn-primary-outlined">Tambah Pendidikan</button>
                                    @endif
                                </div>
                            </div>

                            @if ($user->profile->educations->isNotEmpty())
                                <div class="flex flex-col gap-4 mt-4">
                                    @foreach ($user->profile->educations->sortByDesc('graduate_year')->slice(0, 3) as $edu)
                                        @include('user.profiles._components.education-item', [
                                            'education' => $edu,
                                        ])
                                    @endforeach

                                    @if (count($user->profile->educations) > 3)
                                        <div class="flex justify-center">
                                            <button class="flex items-center gap-2 btn-ghost"
                                                onclick="openModal(this)" data-tw-toggle="modal"
                                                data-tw-target="#user-profile-education-edit">
                                                Tampilkan Semua
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l14 0" />
                                                    <path d="M13 18l6 -6" />
                                                    <path d="M13 6l6 6" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    @php
                        use Carbon\Carbon;
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-buildings">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" />
                                        <path d="M16 8h2c1 0 2 1 2 2v11" />
                                        <path d="M3 21h18" />
                                        <path d="M10 12v0" />
                                        <path d="M10 16v0" />
                                        <path d="M10 8v0" />
                                        <path d="M7 12v0" />
                                        <path d="M7 16v0" />
                                        <path d="M7 8v0" />
                                        <path d="M17 12v0" />
                                        <path d="M17 16v0" />
                                    </svg>
                                    Riwayat Data Pekerjaan
                                </div>
                                <div class="flex gap-4">
                                    @if (count($user->profile->experiences) > 0)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-work-experience-edit"
                                            class="btn-secondary">Edit</button>
                                    @else
                                        <button onclick="openAddModal(this)"
                                            data-action="{{ route('users.profiles.work-experiences.store') }}"
                                            data-tw-toggle="modal" data-tw-target="#user-profile-work-experience-form"
                                            class="btn-primary-outlined">Tambah Pengalaman</button>
                                    @endif
                                </div>
                            </div>
                            @if ($user->profile->experiences->isNotEmpty())
                                <div class="flex flex-col gap-4 mt-4">
                                    @if (count($user->profile->experiences) > 0)
                                        @foreach ($user->profile->experiences->sort(function ($a, $b) {
            $aWorking = boolval($a->currently_working);
            $bWorking = boolval($b->currently_working);

            // If both experiences have the same currently_working status, compare dates.
            if ($aWorking === $bWorking) {
                if ($aWorking) {
                    // Both are currently working; sort by descending start date.
                    $aStart = Carbon::parse($a->start_at)->timestamp;
                    $bStart = Carbon::parse($b->start_at)->timestamp;
                    return $bStart <=> $aStart;
                } else {
                    // Both are finished; sort by descending end date.
                    $aEnd = Carbon::parse($a->end_at)->timestamp;
                    $bEnd = Carbon::parse($b->end_at)->timestamp;
                    if ($bEnd === $aEnd) {
                        $aStart = Carbon::parse($a->start_at)->timestamp;
                        $bStart = Carbon::parse($b->start_at)->timestamp;
                        return $bStart <=> $aStart;
                    }
                    return $bEnd <=> $aEnd;
                }
            }
            // Experiences with currently_working true are sorted first.
            return $aWorking ? -1 : 1;
        })->slice(0, 3) as $exp)
                                            @include('user.profiles._components.work-experience-item', [
                                                'experience' => $exp,
                                            ])
                                        @endforeach
                                        @if (count($user->profile->experiences) > 3)
                                            <div class="flex justify-center">
                                                <button class="flex items-center gap-2 btn-ghost"
                                                    onclick="openModal(this)" data-tw-toggle="modal"
                                                    data-tw-target="#user-profile-work-experience-edit">
                                                    Tampilkan Semua
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l14 0" />
                                                        <path d="M13 18l6 -6" />
                                                        <path d="M13 6l6 6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                    </svg>
                                    Prestasi
                                </div>
                                <div class="flex gap-4">
                                    @if (count($user->profile->achievements) > 0)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-achievement-edit"
                                            class="btn-secondary">Edit</button>
                                    @else
                                        <button onclick="openAddModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-achievement-form"
                                            data-action="{{ route('users.profiles.achievements.store') }}"
                                            class="btn-primary-outlined">Tambah Prestasi</button>
                                    @endif
                                </div>
                            </div>
                            @if ($user->profile->achievements->isNotEmpty())
                                <div class="flex flex-col gap-4 mt-4">
                                    @foreach ($user->profile->achievements->sortByDesc('achievement_year')->slice(0, 3) as $item)
                                        @include('user.profiles._components.achievement-item', [
                                            'achievement' => $item,
                                        ])
                                    @endforeach

                                    @if (count($user->profile->achievements) > 3)
                                        <div class="flex justify-center">
                                            <button class="flex items-center gap-2 btn-ghost"
                                                onclick="openModal(this)" data-tw-toggle="modal"
                                                data-tw-target="#user-profile-achievement-edit">
                                                Tampilkan Semua
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-right">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M5 12l14 0" />
                                                    <path d="M13 18l6 -6" />
                                                    <path d="M13 6l6 6" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-sparkles">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M16 18a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm0 -12a2 2 0 0 1 2 2a2 2 0 0 1 2 -2a2 2 0 0 1 -2 -2a2 2 0 0 1 -2 2zm-7 12a6 6 0 0 1 6 -6a6 6 0 0 1 -6 -6a6 6 0 0 1 -6 6a6 6 0 0 1 6 6z" />
                                    </svg>
                                    Kompetensi
                                </div>
                                <div class="flex gap-4">
                                    @if ($user->profile->skills->isNotEmpty())
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-skill-form"
                                            class="btn-secondary">Edit</button>
                                    @else
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-skill-form"
                                            class="btn-primary-outlined">Tambah
                                            Kompetensi</button>
                                    @endif
                                </div>
                            </div>
                            @if ($user->profile->skills->isNotEmpty())
                                <div class="text-xl font-bold">
                                    @if (is_array(json_decode($user->profile->main_skill, true)))
                                        {{ implode(', ', json_decode($user->profile->main_skill, true)) }}
                                    @else
                                        {{ $user->profile->main_skill }}
                                    @endif
                                </div>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    @foreach ($user->profile->skills as $skill)
                                        <div class="flex">
                                            <div class="px-4 py-2 text-white cursor-pointer bg-primary-500">
                                                {{ $skill->skill_name }}
                                            </div>
                                            <button class="text-white btn-icon bg-primary-500" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal"
                                                onclick="openDeleteModal(this,'{{ route('users.profiles.skills.delete', ['id' => $skill->skill_id]) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-description">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 17h6" />
                                        <path d="M9 13h6" />
                                    </svg>
                                    Dokumen SKKNI BNSP Skema Pendamping KUMKM
                                </div>
                                <div>
                                    @if ($user->profile->fileSKKNI)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-skkni-form"
                                            class="btn-secondary">Edit</button>
                                    @else
                                        @if (count($user->profile->experiences) > 0)
                                            <button onclick="openModal(this)" data-tw-toggle="modal"
                                                data-tw-target="#user-profile-skkni-form"
                                                class="btn-primary-outlined">Tambah Dokumen</button>
                                        @else
                                            <button onclick="openModal(this)" data-tw-toggle="modal"
                                                data-tw-target="#user-profile-skkni-form"
                                                class="btn-secondary">Edit</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @if ($user?->profile?->fileSkkni)
                                <div class="mt-4">
                                    <div
                                        class="flex items-center justify-between w-full p-4 rounded-xl md:w-1/2 bg-gray-50/25">
                                        <a class="flex items-center gap-4 truncate" role="button"
                                            href="{{ route('users.profiles.skkni.show') }}">
                                            <img class="size-8" src="{{ asset('assets/img/pdf.png') }}"
                                                alt="Pdf icons created by Dimitry Miroliubov - Flaticon">
                                            <span class="truncate">{{ $user?->profile?->fileSkkni?->filename }}</span>
                                        </a>
                                        <div>
                                            <button class="btn-icon" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal"
                                                onclick="openDeleteModal(this, '{{ route('users.profiles.skkni.delete') }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-description">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 17h6" />
                                        <path d="M9 13h6" />
                                    </svg>
                                    Dokumen SKKK Konsultan Pratama ABDSI / IBCF dan / Sejenisnya
                                </div>
                                <div>
                                    @if ($user?->profile?->fileSkkk)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-skkk-form"
                                            class="btn-secondary">Edit</button>
                                    @else
                                        @if (count($user->profile->experiences) > 0)
                                            <button onclick="openModal(this)" data-tw-toggle="modal"
                                                data-tw-target="#user-profile-skkk-form"
                                                class="btn-primary-outlined">Tambah Dokumen</button>
                                        @else
                                            <button onclick="openModal(this)" data-tw-toggle="modal"
                                                data-tw-target="#user-profile-skkk-form"
                                                class="btn-secondary">Edit</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @if ($user?->profile?->fileSkkk)
                                <div class="mt-4">
                                    <div
                                        class="flex items-center justify-between w-full p-4 rounded-xl md:w-1/2 bg-gray-50/25">
                                        <a class="flex items-center gap-4 truncate" role="button"
                                            href="{{ route('users.profiles.skkk.show') }}">
                                            <img class="size-8" src="{{ asset('assets/img/pdf.png') }}"
                                                alt="Pdf icons created by Dimitry Miroliubov - Flaticon">
                                            <span class="truncate">{{ $user?->profile?->fileSkkk?->filename }}</span>
                                        </a>
                                        <div>
                                            <button class="btn-icon" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal"
                                                onclick="openDeleteModal(this, '{{ route('users.profiles.skkk.delete') }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="flex items-center justify-between header">
                                <div class="flex items-center gap-4 font-semibold text-primary-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-description">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 17h6" />
                                        <path d="M9 13h6" />
                                    </svg>
                                    CV
                                </div>
                                <div>
                                    @if (!$user?->profile?->fileCV)
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-cv-form" class="btn-primary-outlined">Tambah
                                            Dokumen CV</button>
                                    @else
                                        <button onclick="openModal(this)" data-tw-toggle="modal"
                                            data-tw-target="#user-profile-cv-form" class="btn-secondary">Edit</button>
                                    @endif
                                </div>
                            </div>
                            @if ($user?->profile?->fileCV)
                                <div class="mt-4">
                                    <div
                                        class="flex items-center justify-between w-full p-4 rounded-xl md:w-1/2 bg-gray-50/25">
                                        <a class="flex items-center gap-4 truncate" role="button"
                                            href="{{ route('users.profiles.cv.show') }}">
                                            <img class="size-8" src="{{ asset('assets/img/pdf.png') }}"
                                                alt="Pdf icons created by Dimitry Miroliubov - Flaticon">
                                            <span class="truncate">{{ $user?->profile?->fileCV?->filename }}</span>
                                        </a>
                                        <div>
                                            <button class="btn-icon" data-tw-toggle="modal"
                                                data-tw-target="#delete-confirmation-modal"
                                                onclick="openDeleteModal(this, '{{ route('users.profiles.cv.delete') }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
