@extends('partner._layout.main')

@section('title', 'List Konsultan')

@section('content')
    <div class="flex flex-col flex-grow w-full p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Konsultan</h1>
        <form method="GET" action="{{ route('partners.freelancers.index') }}" class="mb-4">
            <div class="flex flex-col sm:flex-row gap-4">
                <div>
                    <label for="skill" class="block text-sm font-medium text-gray-700">Filter Kompetensi Utama:</label>
                    <select name="skill" id="skill" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="pendamping" {{ ($skillFilter ?? '') === 'pendamping' ? 'selected' : '' }}>Pendamping
                        </option>
                        <option value="konsultan" {{ ($skillFilter ?? '') === 'konsultan' ? 'selected' : '' }}>Konsultan
                        </option>
                    </select>
                </div>
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700">Filter Provinsi:</label>
                    <select name="province" id="province" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        onchange="this.form.submit()">
                        <option value="">Semua Provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}"
                                {{ ($provinceFilter ?? '') == $province->province_id ? 'selected' : '' }}>
                                {{ $province->province_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700">Filter Kabupaten/Kota:</label>
                    <select name="district" id="district" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        onchange="this.form.submit()">
                        <option value="">Semua Kab/Kota</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->district_id }}"
                                {{ ($districtFilter ?? '') == $district->district_id ? 'selected' : '' }}>
                                {{ $district->district_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($freelancers as $user)
                @php
                    $profile = $user->freelancerProfile;
                    $provinceName = $profile->province ? $profile->province->province_name : 'N/A';
                    $districtName = $profile->district ? $profile->district->district_name : 'N/A';
                    // Ensure main_skill is an array
                    $mainSkill = $profile->main_skill;
                    if (!is_array($mainSkill)) {
                        $decoded = json_decode($mainSkill, true);
                        $mainSkillArray =
                            json_last_error() === JSON_ERROR_NONE && is_array($decoded) ? $decoded : [$mainSkill];
                    } else {
                        $mainSkillArray = $mainSkill;
                    }
                @endphp
                <div class="bg-white rounded-md shadow p-4">
                    @if ($profile->photoProfile)
                        <img id="profilePicture" src="{{ $profile->photoProfile->public_url }}"
                            class="w-16 rounded-full h-16 mb-2" alt="Profile Picture" />
                    @else
                        <img id="profilePicture" src="/assets/img/default-avatar.jpg" class="w-16 rounded-full h-16 mb-2"
                            alt="Default Profile Picture" />
                    @endif
                    <p class="font-bold text-lg pt-2">
                        <a href="{{ route('partners.freelancers.detail', ['id' => $user->user_id]) }}"
                            class="hover:underline">
                            {{ $profile->name }}
                        </a>
                    </p>
                    <!-- Updated main_skill display -->
                    <p class="pt-4 font-bold">Kompetensi</p>
                    <div class="flex flex-col gap-1">
                        <p class="text-sm">
                            {{ count($mainSkillArray) ? implode(', ', $mainSkillArray) : 'N/A' }}
                        </p>
                        @if ($profile->skills->isNotEmpty())
                            <p class="text-sm mt-1">
                                &bull; {{ $profile->skills->pluck('skill_name')->implode(', ') }}
                            </p>
                        @else
                            <p class="text-sm mt-1">&bull; N/A</p>
                        @endif
                    </div>
                    <div class="py-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                        </svg>
                        <p class="text-sm">{{ $provinceName }}, {{ $districtName }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
