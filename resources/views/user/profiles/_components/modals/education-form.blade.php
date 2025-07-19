<div class="relative z-50 modal hidden" id="user-profile-education-form" aria-labelledby="modal-title" role="dialog"
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
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Lengkapi Data Riwayat Pendidikan</h3>
                        <form class="space-y-4 form-user-profile-education-form"
                            action="{{ route('users.profiles.educations.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="text" name="freelancer_profile_id"
                                value="{{ $user->profile->freelancer_profile_id }}" class="hidden">
                            <input type="text" name="freelancer_educations_id" class="hidden">
                            <div>
                                <label for="name" class="form-label">Nama Instansi Pendidikan</label>
                                <input type="text" name="school_name" id="name"
                                    placeholder="Nama universitas atau sekolah" required class="form-input-text" />
                            </div>
                            <div>
                                <label for="major" class="form-label">Jurusan atau Program Studi</label>
                                <input type="text" name="major" id="major" placeholder="Jurusan" required
                                    class="form-input-text" />
                            </div>
                            <div>
                                <label for="education_desc" class="form-label">Deskripsi Pendidikan</label>
                                <textarea name="education_desc" id="education_desc" class="form-input-text" rows="5"
                                    placeholder="Deskripsi pendidikan"></textarea>
                            </div>
                            <div class="w-full">
                                <label for="graduate_year" class="form-label">Tahun Lulus</label>
                                <input name="graduate_year" class="form-input-text" type="number" value="">
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
