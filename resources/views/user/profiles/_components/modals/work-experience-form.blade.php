<div class="relative z-50 modal hidden" id="user-profile-work-experience-form" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div onclick="closeModal(this)" class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay">
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
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Lengkapi Riwayat Data Pekerjaan</h3>
                        <form class="space-y-4 form-user-profile-work-experience-form"
                            action="{{ route('users.profiles.work-experiences.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="text" name="freelancer_experience_id" class="hidden">
                            <input type="text" name="freelancer_profile_id"
                                value="{{ $user->profile->freelancer_profile_id }}" class="hidden">
                            <div>
                                <label for="name" class="form-label">Nama Instansi / Perusahaan</label>
                                <input type="text" name="company_name" id="name" placeholder="Nama Perusahaan"
                                    required class="form-input-text" />
                            </div>
                            <div>
                                <label for="position" class="form-label">Posisi / Jabatan</label>
                                <input type="text" name="job_title" id="position" placeholder="Posisi" required
                                    class="form-input-text" />
                            </div>
                            <div>
                                <label for="employment_type" class="form-label">Jenis Pekerjaan</label>
                                <div class="h-10 flex">
                                    <select name="employment_type" id="employment_type" class="form-select">
                                        <option value="full-time">Full Time</option>
                                        <option value="part-time">Part Time</option>
                                        <option value="project">Proyek</option>
                                        <option value="internship">Internship</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="job_desc" class="form-label">Deskripsi Pekerjaan</label>
                                <textarea name="job_desc" id="job_desc" class="form-input-text" rows="5" placeholder="Deskripsi pekerjaan"></textarea>
                            </div>
                            <div>
                                <label for="project_link" class="form-label">Link Projek atau Perusahaan</label>
                                <input type="text" name="project_link" class="form-input-text">
                            </div>
                            <div class="flex gap-4">
                                <div class="w-full">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input name="start_at" class="form-input-text" type="date" value="2019-08-19"
                                        id="start_date">
                                </div>
                                <div class="w-full" id="end-date-container">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input name="end_at" class="form-input-text" type="date" value="2019-08-19"
                                        id="end_date">
                                </div>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="currently_working" id="currently_working"
                                    class="form-checkbox" value="1">
                                <label for="currently_working" class="ml-2">Masih bekerja</label>
                            </div>
                            <div>
                                <label for="city" class="form-label">Lokasi Pekerjaan</label>
                                <input type="text" name="city" class="form-input-text"
                                    placeholder="Nama Lokasi">
                            </div>
                            <div class="mt-6 flex justify-end gap-4">
                                <button type="button" class="btn-outlined" data-tw-dismiss="modal"
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
    // JavaScript to disable the "end_date" field when "Masih bekerja" checkbox is checked and add faded style
    document.addEventListener("DOMContentLoaded", function() {
        const currentlyWorkingCheckbox = document.getElementById('currently_working');
        const endDateInput = document.getElementById('end_date');

        function toggleEndDate() {
            if (currentlyWorkingCheckbox.checked) {
                endDateInput.disabled = true;
                endDateInput.value = '';
                endDateInput.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                endDateInput.disabled = false;
                endDateInput.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        // Bind event listener
        currentlyWorkingCheckbox.addEventListener('change', toggleEndDate);

        // Check initial state on page load
        toggleEndDate();
    });
</script>
