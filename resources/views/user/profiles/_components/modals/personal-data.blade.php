<div class="relative z-50 modal hidden " id="user-profile-personal-data" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div onclick="closeModal(this)" class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay ">
        </div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button onclick="closeModal(this)" type="button" class="absolute top-3 right-3 btn-icon"
                        data-tw-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Lengkapi Data Diri</h3>
                        <form class="space-y-4" action="{{ route('users.profiles.update-personal-data') }}"
                            method="POST">
                            @csrf
                            <input type="text" class="hidden" name="profile_id" id="profile_id"
                                value="{{ $user->profile->freelancer_profile_id }}">
                            <div>
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" value="{{ $user->profile->name }}" id="name"
                                    placeholder="Nama" required class="form-input-text" />
                            </div>
                            <div>
                                <label for="birth-date" class="form-label">Tanggal Lahir</label>
                                <input name="birthdate" class="form-input-text" value="{{ $user->profile->birthdate }}"
                                    type="date" value="2019-08-19" id="birthdate">
                            </div>
                            <div>
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <div class="flex h-10">
                                    <select name="gender" class="form-select">
                                        <option value="1" @selected($user->profile->gender == 1)>Laki-laki</option>
                                        <option value="2" @selected($user->profile->gender == 2)>Perempuan</option>
                                        <option value="3" @selected($user->profile->gender == 3)>Tidak Ditentukan</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="address" class="form-label">Alamat</label>
                                <textarea name="address" id="" rows="5" class="form-input-text" placeholder="Alamat" required>{{ $user->profile->address }}</textarea>
                            </div>
                            <div>
                                <label for="province" class="form-label">Provinsi</label>
                                <div class="flex h-10">
                                    <select name="province_id" class="form-select" id="select_province">
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province_id }}" @selected($user->profile->province_id == $province->province_id)>
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
                                            <option value="{{ $district->district_id }}" @selected($user->profile->district_id == $district->district_id)>
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
                                                @selected($user->profile->subdistrict_id == $subdistrict->subdistrict_id)>
                                                {{ $subdistrict->subdistrict_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ $user->profile->postal_code }}"
                                    id="postal_code" placeholder="Kode Pos" required class="form-input-text" />
                            </div>
                            <div>
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone_number" value="{{ $user->profile->phone_number }}"
                                    id="phone" placeholder="Nomor Telepon" required class="form-input-text" />
                            </div>

                            <div class="mt-6 flex justify-end gap-4">
                                <button type="button" class="btn-outlined " data-tw-dismiss="modal"
                                    onclick="closeModal(this)">Kembali</button>
                                <button type="submit" class="btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('select_province');
        const districtSelect = document.getElementById('select_district');
        const subdistrictSelect = document.getElementById('select_subdistrict');

        // Get saved IDs from the profile
        const savedProvinceId = '{{ $user->profile->province_id }}';
        const savedDistrictId = '{{ $user->profile->district_id }}';
        const savedSubdistrictId = '{{ $user->profile->subdistrict_id }}';

        // Load districts on initial page load if province is selected
        if (savedProvinceId) {
            loadDistricts(savedProvinceId, savedDistrictId);
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
                        loadSubdistricts(presetDistrictId, savedSubdistrictId);
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
