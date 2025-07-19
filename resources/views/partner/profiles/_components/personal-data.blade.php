<div id="edit-profile-modal" class="relative z-50 modal hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button type="button" class="absolute top-3 right-3 btn-icon" id="close-profile-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Lengkapi Data Perusahaan</h3>
                        <form class="space-y-4" action="{{ route('partners.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Form Fields -->
                            <div>
                                <label for="partner_name" class="form-label">Nama Instansi</label>
                                <input type="text" name="partner_name" value="{{ $partner->partner_name }}"
                                    id="partner_name" placeholder="Nama Instansi" required class="form-input-text" />
                                @error('partner_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="organization" class="form-label">Organisasi</label>
                                <div class="flex h-10">
                                    <select name="organization_id" class="form-select" id="select_organization">
                                        @foreach ($organization as $prov)
                                            <option value="{{ $prov->organization_id }}" @selected($prov->organization_id == $partner->organization_id)>
                                                {{ $prov->organization_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="address" class="form-label">Alamat</label>
                                <textarea name="address" id="address" rows="5" class="form-input-text" placeholder="Alamat" required>{{ $partner->address }}</textarea>
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
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
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" name="postal_code" id="postal_code" placeholder="Kode Pos"
                                    value="{{ $partner->postal_code }}" required class="form-input-text" />
                                @error('postal_code')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="phone_number" class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone_number" id="phone_number" placeholder="Nomor Telepon"
                                    value="{{ $partner->phone_number }}" required class="form-input-text" />
                                @error('phone_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-6 flex justify-between gap-4">
                                <button type="submit" class="btn-primary w-full">Simpan</button>
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
