<div class="relative z-50 modal hidden" id="user-profile-website" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button type="button" class="absolute top-3 right-3 btn-icon" data-tw-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Lengkap Data Narahubung Mitra</h3>
                        <form class="space-y-4" action="{{ route('partners.profile.updateWebsite') }}" method="POST">
                            @csrf
                            <div>
                                <label for="website"
                                    class="block mb-2 text-sm font-medium text-gray-900 text-left">Website
                                    Perusahaan</label>
                                <input type="text" name="website" id="website"
                                    placeholder="Masukan website perusahaan" class="form-input-text"
                                    value="{{ old('website', $partner->website) }}" required>
                                @error('website')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mt-6 flex justify-between gap-4">
                                <button type="submit" class="btn-primary w-full">Simpan</button>
                                <button type="button" class="btn-outlined w-full"
                                    data-tw-dismiss="modal">Kembali</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
