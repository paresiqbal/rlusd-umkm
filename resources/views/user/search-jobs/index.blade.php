@extends('common._layout.main-user')

@section('title', 'Cari Pekerjaan')

@section('content')

    <div class="flex flex-col lg:flex-row lg:gap-4">
        <div class="lg:hidden">
            @include('user.search-jobs._components.search-bar')
        </div>

        <div class="mt-4 lg:w-3/12">
            <span class="font-bold text-lg block mb-4">
                Filter Pencarian
            </span>
            <div class="flex flex-col gap-4">
                <div>
                    <label for="job_type" class="form-label">Tipe Pekerjaan</label>
                    <select name="job_type" id="job_type" class="form-select h-10" onchange="applyFilters()">
                        <option value="">Pilih</option>
                        @foreach ($job_type as $jt)
                            <option value="{{ $jt->employment_type_id }}"
                                {{ request('job_type') == $jt->employment_type_id ? 'selected' : '' }}>
                                {{ $jt->employment_type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="location" class="form-label">Lokasi</label>
                    <select name="location" id="location" class="form-select h-10" onchange="applyFilters()">
                        <option value="">Pilih</option>
                        @foreach ($provinces as $prov)
                            <optgroup label="{{ $prov->province_name }}">
                                @foreach ($prov->district as $item)
                                    <option value="{{ $item->district_id }}"
                                        {{ request('location') == $item->district_id ? 'selected' : '' }}>
                                        {{ $item->district_name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="education" class="form-label">Pendidikan</label>
                    <select name="education" id="education" class="form-select h-10" onchange="applyFilters()">
                        <option value="">Pilih</option>
                        @foreach ($education as $edu)
                            <option value="{{ $edu->education_id }}"
                                {{ request('education') == $edu->education_id ? 'selected' : '' }}>
                                {{ $edu->education_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="skills" class="form-label">Keahlian</label>
                    <input type="text" id="skills" name="skills"
                        class="form-input h-10 w-full rounded-sm border-inherit" placeholder="Cari keahlian"
                        onblur="applyFilters()" value="{{ request('skills') }}">
                </div>
                <div>
                    <label for="service_type" class="form-label">Jenis Pelayanan</label>
                    <select name="service_type" id="service_types" class="form-select h-10" onchange="applyFilters()">
                        <option value="">Pilih</option>
                        @foreach ($service_types as $service)
                            <option value="{{ $service->service_type_id }}"
                                {{ request('service_type') == $service->service_type_id ? 'selected' : '' }}>
                                {{ $service->service_type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="lg:w-9/12">
            <div class="hidden lg:flex">
                @include('user.search-jobs._components.search-bar')
            </div>
            <div class="flex flex-col lg:flex-row lg:flex-wrap gap-4 lg:gap-x-0 lg:gap-y-8 lg:justify-evenly mt-8">
                @foreach ($jobs->sortByDesc('created_at') as $job)
                    @include('user.search-jobs._components.job-item', ['job' => $job])
                @endforeach
            </div>
            <div class="mt-4">
                {{ $jobs->onEachSide(1)->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Function to apply filters
        function applyFilters() {
            let jobType = document.getElementById('job_type').value;
            let location = document.getElementById('location').value;
            let education = document.getElementById('education').value;
            let skills = document.getElementById('skills').value;
            let serviceType = document.getElementById('service_types').value;

            let params = new URLSearchParams();

            if (jobType) params.append('job_type', jobType);
            if (location) params.append('location', location);
            if (education) params.append('education', education);
            if (skills) params.append('skills', skills);
            if (serviceType) params.append('service_type', serviceType);

            window.location.search = params.toString();
        }
    </script>
@endpush
