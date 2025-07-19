<div id="tambahLowonganModal" class="relative z-50 hidden modal" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button type="button" class="absolute top-3 right-3 btn-icon" id="closeLowongan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Tambah Jasa</h3>
                        <form class="space-y-4" action="{{ route('partners.jobs.store') }}" method="POST">
                            @csrf
                            <p class="pb-6">Posting kebutuhan jasa baru.</p>
                            <div>
                                <label for="roleTitle" class="form-label">Judul Pekerjaan</label>
                                <input type="text" id="roleTitle" name="role" class="form-input-text"
                                    placeholder="Judul pekerjaan" required>
                            </div>
                            <div>
                                <label for="jobDescription" class="form-label">Deskripsi Pekerjaan</label>
                                <textarea id="jobDescription" name="job_desc" class="form-input-text" rows="5" placeholder="Deskripsi Pekerjaan"
                                    required></textarea>
                            </div>
                            <div>
                                <label for="number_sdm" class="form-label">Jumlah SDM</label>
                                <input type="number" id="number_sdm" name="number_sdm" class="form-input-text"
                                    placeholder="Jumlah SDM yang dibutuhkan" required>
                            </div>
                            <div>
                                <label for="education" class="form-label">Minimal Pendidikan</label>
                                <div class="flex h-10">
                                    <select name="min_education_id" class="form-select" id="select_education" required>
                                        @foreach ($educations as $education)
                                            <option value="{{ $education->education_id }}" @selected(old('min_education_id') == $education->education_id)>
                                                {{ $education->education_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select id="genders" name="genders" class="h-10 form-select" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="1">Laki Laki</option>
                                    <option value="2">Perempuan</option>
                                    <option value="3">Tidak ditentukan</option>
                                </select>
                            </div>
                            <div>
                                <label for="employment" class="form-label">Jenis Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="employment_type_id" class="form-select" id="select_employment"
                                        required>
                                        @foreach ($employmentTypes as $employment)
                                            <option value="{{ $employment->employment_type_id }}"
                                                @selected(old('employment_type_id') == $employment->employment_type_id)>
                                                {{ $employment->employment_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Jenis Layanan</label>
                                <div class="grid grid-cols-2 gap-2 mt-1">
                                    @foreach ($serviceTypes as $serviceType)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="service_types[]"
                                                value="{{ $serviceType->service_type_id }}" class="form-checkbox">
                                            <span class="ml-2">{{ $serviceType->service_type_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('service_types')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="jobCategory" class="form-label"> Kategori Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="job_category_id" class="form-select" id="jobCategory" required>
                                        @foreach ($sectors as $sector)
                                            <option value="{{ $sector->sector_id }}" @selected(old('job_category_id') == $sector->sector_id)>
                                                {{ $sector->sector_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h5 class="pt-4 text-lg font-medium text-gray-500">
                                Lokasi Pekerjaan
                            </h5>
                            <div>
                                <label for="province" class="form-label">Provinsi</label>
                                <div class="flex h-10">
                                    <select name="province_id" class="form-select" id="select_province">
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province_id }}" @selected($partner->province_id == $province->province_id)>
                                                {{ $province->province_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="district" class="form-label">Kabupaten/Kota</label>
                                <div class="flex h-10">
                                    <select name="district_id" class="form-select" id="select_district">
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->district_id }}" @selected($partner->district_id == $district->district_id)>
                                                {{ $district->district_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="subdistrict" class="form-label">Kecamatan</label>
                                <div class="flex h-10">
                                    <select name="subdistrict_id" class="form-select" id="select_subdistrict">
                                        @foreach ($subdistricts as $subdistrict)
                                            <option value="{{ $subdistrict->subdistrict_id }}"
                                                @selected($partner->subdistrict_id == $subdistrict->subdistrict_id)>
                                                {{ $subdistrict->subdistrict_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="address" class="form-label">Alamat</label>
                                <textarea type="text" id="address" name="address" class="form-input-text" rows="4"
                                    placeholder="Alamat perusahaan" required></textarea>
                            </div>
                            <div>
                                <label for="jobType" class="form-label">Tipe Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="job_type_id" class="form-select" id="select_job_type" required>
                                        <option value="" disabled selected>Pilih Tipe Pekerjaan</option>
                                        @foreach ($jobTypes as $jobType)
                                            <option value="{{ $jobType->job_type_id }}" @selected(old('job_type_id') == $jobType->job_type_id)>
                                                {{ $jobType->job_type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="qualifications" class="form-label">Syarat dan Kualifikasi</label>
                                <textarea id="qualifications" name="qualifications" class="form-input-text" rows="5"
                                    placeholder="Syarat dan Kualifikasi" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="skills" class="block text-gray-700">Kompetensi yang Dibutuhkan</label>
                                <select name="skills[]" id="skills" multiple class="block w-full mt-1 form-select"
                                    required>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->skill_id }}">{{ $skill->skill_name }}</option>
                                    @endforeach
                                </select>
                                @error('skills')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="salaryRange" class="form-label">Rentang Gaji</label>
                                <div class="flex gap-2">
                                    <input type="number" id="minSalary" name="min_salary" class="form-input-text"
                                        placeholder="Gaji Minimum" required>
                                    <input type="number" id="maxSalary" name="max_salary" class="form-input-text"
                                        placeholder="Gaji Maksimum" required>
                                </div>
                            </div>
                            <div>
                                <label for="isHiddenSalary" class="flex items-center form-label">
                                    <input type="hidden" name="is_hidden_salary" value="0">
                                    <input type="checkbox" id="isHiddenSalary" name="is_hidden_salary"
                                        value="1"
                                        class="mr-2 rounded-sm outline-none form-checkbox text-primary-500">
                                    Sembunyikan Gaji
                                </label>
                            </div>
                            <input type="hidden" name="country_id" value="1">
                            <div class="flex justify-between gap-4 pt-4 mt-6">
                                <button type="submit" class="w-full btn-primary" id="saveJob">Simpan</button>
                                <button type="button" class="w-full btn-outlined" id="closeLowongan">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- Tom Select --}}
    <script src="{{ asset('assets/js/libs/tom-select/tom-select.complete.js') }}"></script>
    <script>
        const jobSkill = new TomSelect('[name="skills[]"]', {
            valueField: 'skill_id',
            labelField: 'skill_name',
            searchField: 'skill_name',
            loadThrottle: 1000,
            create:true,
            createFilter: function(input) {
                return !/^\d+$/.test(input)
            },
            load: function(query, callback) {
                console.log('Fetching.............')
                let url = '{{ url('/') }}/api/skill-list?query=' + encodeURIComponent(query)
                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        callback(json)
                        console.log(json)
                    })
                    .catch((e) => {
                        callback()
                    })
            },
            onInitialize: function() {
                document.querySelector('.ts-control').style.border = 'unset'
                document.querySelector('.ts-control').classList.add('bg-transparent')
                document.querySelector('.ts-control').classList.add('border-0')

                document.querySelector('.ts-dropdown').style.border = 'unset'
                document.querySelector('.ts-wrapper').style.zIndex = '99999'
            },
            onChange: function(value) {
                this.close()
            },
            render: {
                option_create: function(data, escape) {
                  return `<div class="create">Tambahkan <b>${escape(data.input)}...</b></div>`  
                },
                loading: function(data, escape) {
                    return `
            <div class="flex items-center justify-center p-4 overflow-hidden">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-[3px] border-l-transparent border-yellow-500 rounded-full">
                    <span class="hidden">Loading...</span>
                </div>
            </div>`
                },
            },
            plugins: {
                remove_button: {
                    title: 'Hapus Item'
                }
            },
        });
    </script>
    {{-- Tom Select End --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('select_province');
            const districtSelect = document.getElementById('select_district');
            const subdistrictSelect = document.getElementById('select_subdistrict');

            // Initial load if province is selected
            if (provinceSelect.value) {
                loadDistricts(provinceSelect.value, '{{ $partner->district_id }}');
            }

            // Province change handler
            provinceSelect.addEventListener('change', function() {
                loadDistricts(this.value);
            });

            // District change handler
            districtSelect.addEventListener('change', function() {
                loadSubdistricts(this.value);
            });

            function loadDistricts(provinceId, presetDistrictId = null) {
                fetch(`/districts/${provinceId}`)
                    .then(response => response.json())
                    .then(districts => {
                        districtSelect.innerHTML = districts.map(district => `
                            <option value="${district.district_id}" 
                                ${district.district_id == presetDistrictId ? 'selected' : ''}>
                                ${district.district_name}
                            </option>
                        `).join('');

                        // Auto-load subdistricts if district has value
                        if (presetDistrictId) {
                            loadSubdistricts(presetDistrictId, '{{ $partner->subdistrict_id }}');
                        }
                    });
            }

            function loadSubdistricts(districtId, presetSubdistrictId = null) {
                fetch(`/subdistricts/${districtId}`)
                    .then(response => response.json())
                    .then(subdistricts => {
                        subdistrictSelect.innerHTML = subdistricts.map(subdistrict => `
                            <option value="${subdistrict.subdistrict_id}" 
                                ${subdistrict.subdistrict_id == presetSubdistrictId ? 'selected' : ''}>
                                ${subdistrict.subdistrict_name}
                            </option>
                        `).join('');
                    });
            }
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tom-select.min.css') }}">
@endpush
