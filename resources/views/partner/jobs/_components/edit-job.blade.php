<div id="editLowonganModal" class="relative z-50 hidden modal" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button type="button" class="absolute top-3 right-3 btn-icon" id="closeEditLowongan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Edit Jasa</h3>
                        <form id="editJobForm" class="space-y-4" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit_post_job_id" name="post_job_id">
                            <p class="pb-6">Update kebutuhan jasa.</p>
                            <div>
                                <label for="role" class="form-label">Judul Pekerjaan</label>
                                <input type="text" id="edit_role" name="role" class="form-input-text">
                            </div>
                            <div>
                                <label for="job_desc" class="form-label">Deskripsi Pekerjaan</label>
                                <textarea type="text" id="edit_job_desc" rows="5" name="job_desc" class="form-input-text"></textarea>
                            </div>
                            <div>
                                <label for="number_sdm" class="form-label">Jumlah SDM</label>
                                <input type="number" id="edit_number_sdm" name="number_sdm" class="form-input-text">
                            </div>
                            <div>
                                <label for="education" class="form-label">Minimal Pendidikan</label>
                                <div class="flex h-10">
                                    <select name="min_education_id" class="form-select" id="edit_select_education">
                                        @foreach ($educations as $education)
                                            <option value="{{ $education->education_id }}" @selected(old('min_education_id') == $education->education_id)>
                                                {{ $education->education_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="edit_gender" class="form-label">Jenis Kelamin</label>
                                <select id="edit_genders" name="genders" class="h-10 form-select" required>
                                    <option value="1">Laki Laki</option>
                                    <option value="2">Perempuan</option>
                                    <option value="3">Tidak ditentukan</option>
                                </select>
                                @error('genders')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="salaryRange" class="form-label">Rentang Gaji</label>
                                <div class="flex gap-2">
                                    <input type="number" id="edit_min_salary" name="min_salary" class="form-input-text"
                                        placeholder="Gaji Minimum">
                                    <input type="number" id="edit_max_salary" name="max_salary" class="form-input-text"
                                        placeholder="Gaji Maksimum">
                                </div>
                            </div>
                            <div>
                                <label for="isHiddenSalary" class="flex items-center form-label">
                                    <input type="checkbox" id="editHiddenSalary" name="is_hidden_salary"
                                        class="mr-2 rounded-sm outline-none form-checkbox text-primary-500">
                                    Sembunyikan Gaji
                                </label>
                            </div>
                            <div>
                                <label for="employment" class="form-label">Jenis Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="employment_type_id" class="form-select" id="edit_select_employment">
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
                                <label for="jobCategory" class="form-label">Kategori Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="job_category_id" class="form-select" id="edit_job_category">
                                        @foreach ($sectors as $sector)
                                            <option value="{{ $sector->sector_id }}" @selected(old('job_category_id') == $sector->sector_id)>
                                                {{ $sector->sector_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="province" class="form-label">Provinsi</label>
                                <div class="flex h-10">
                                    <select name="province_id" class="form-select" id="edit_select_province">
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province_id }}"
                                                @if ($job->province_id ?? false) {{ $province->province_id == $job->province_id ? 'selected' : '' }}
                                                @else
                                                    {{ $partner->province_id == $province->province_id ? 'selected' : '' }} @endif>
                                                {{ $province->province_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="district" class="form-label">Kabupaten/Kota</label>
                                <div class="flex h-10">
                                    <select name="district_id" class="form-select" id="edit_select_district">
                                        @if ($job->district_id ?? false)
                                            @foreach ($districts->where('province_id', $job->province_id) as $district)
                                                <option value="{{ $district->district_id }}"
                                                    {{ $district->district_id == $job->district_id ? 'selected' : '' }}>
                                                    {{ $district->district_name }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->district_id }}"
                                                    {{ $partner->district_id == $district->district_id ? 'selected' : '' }}>
                                                    {{ $district->district_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="subdistrict" class="form-label">Kecamatan</label>
                                <div class="flex h-10">
                                    <select name="subdistrict_id" class="form-select" id="edit_select_subdistrict">
                                        @if ($job->subdistrict_id ?? false)
                                            @foreach ($subdistricts->where('district_id', $job->district_id) as $subdistrict)
                                                <option value="{{ $subdistrict->subdistrict_id }}"
                                                    {{ $subdistrict->subdistrict_id == $job->subdistrict_id ? 'selected' : '' }}>
                                                    {{ $subdistrict->subdistrict_name }}
                                                </option>
                                            @endforeach
                                        @else
                                            @foreach ($subdistricts as $subdistrict)
                                                <option value="{{ $subdistrict->subdistrict_id }}"
                                                    {{ $partner->subdistrict_id == $subdistrict->subdistrict_id ? 'selected' : '' }}>
                                                    {{ $subdistrict->subdistrict_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="address" class="form-label">Alamat Perusahaan</label>
                                <textarea type="text" id="edit_address" rows="3" name="address" class="form-input-text"></textarea>
                            </div>
                            <div>
                                <label for="jobType" class="form-label">Tipe Pekerjaan</label>
                                <div class="flex h-10">
                                    <select name="job_type_id" class="form-select" id="edit_select_job_type">
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
                                <textarea id="edit_qualifications" name="qualifications" class="form-input-text" rows="5"
                                    placeholder="Syarat dan Kualifikasi"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="skills" class="block text-gray-700">Kompetensi yang Dibutuhkan</label>
                                <select name="skills[]" id="edit_skills" multiple class="block w-full mt-1" required>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->skill_id }}">{{ $skill->skill_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-between gap-4 mt-6">
                                <button type="submit" class="w-full btn-primary" id="updateJob">Perbarui</button>
                                <button type="button" class="w-full btn-outlined"
                                    id="closeEditLowongan">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/libs/tom-select/tom-select.complete.js') }}"></script>
    <script>
        function initializeTomSelect(selector) {
            const element = document.querySelector(selector);
            if (element.tomselect) {
                element.tomselect.destroy();
            }

            return new TomSelect(selector, {
                valueField: 'skill_id',
                labelField: 'skill_name',
                searchField: 'skill_name',
                loadThrottle: 1000,
                create:true,
                createFilter: function(input) {
                    return !/^\d+$/.test(input)
                },
                load: function(query, callback) {
                    let url = '{{ url('/') }}/api/skill-list?query=' + encodeURIComponent(query)
                    fetch(url)
                        .then(response => response.json())
                        .then(json => {
                            callback(json)
                        })
                        .catch((e) => {
                            callback()
                        })
                },
                onInitialize: function() {
                    const tsControl = document.querySelector('.ts-control');
                    if (tsControl) {
                        tsControl.style.border = 'unset';
                        tsControl.classList.add('bg-transparent', 'border-0');
                    }

                    const tsDropdown = document.querySelector('.ts-dropdown');
                    if (tsDropdown) {
                        tsDropdown.style.border = 'unset';
                    }

                    const tsWrapper = document.querySelector('.ts-wrapper');
                    if (tsWrapper) {
                        tsWrapper.style.zIndex = '99999';
                    }
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
        }

        document.addEventListener('DOMContentLoaded', function() {
            initializeTomSelect('#edit_skills');
        });

        document.getElementById('editLowonganModal').addEventListener('show.bs.modal', function() {
            initializeTomSelect('#edit_skills');
        });
    </script>
@endpush
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tom-select.min.css') }}">
@endpush
