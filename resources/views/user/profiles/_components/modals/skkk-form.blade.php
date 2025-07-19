<div class="relative z-50 modal hidden" x-data="skkkUploadHandler" id="user-profile-skkk-form" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
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
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Upload SKKK Anda</h3>
                        <form enctype="multipart/form-data" class="space-y-4"
                            action="{{ route('users.profiles.skkk.update') }}" method="POST"
                            @submit.prevent="submitForm">
                            @csrf
                            <div class="flex items-center justify-center w-full">
                                <label for="input-skkk" x-ref="dropzone"
                                    class="relative py-5 flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100"
                                    :class="{ 'border-green-500': fileSelected, 'border-gray-300': !fileSelected }">
                                    <template x-if="!fileSelected">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                File PDF maksimal berukuran 3MB
                                            </p>
                                        </div>
                                    </template>
                                    <template x-if="fileSelected">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 mb-4 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                            </svg>
                                            <p class="text-sm text-green-600 p-4 text-center" x-text="selectedFileName">
                                            </p>
                                        </div>
                                    </template>
                                    <input type="file" name="skkk_file" @change="handleFileUpload($event)"
                                        accept="application/pdf" id="input-skkk"
                                        class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer">
                                </label>
                            </div>
                            <!-- Display error message when file is too big -->
                            <template x-if="errorMessage">
                                <div class="text-center text-red-600 text-sm" x-text="errorMessage"></div>
                            </template>
                            <div class="mt-6 flex justify-end gap-4">
                                <button type="button" class="btn-outlined" data-tw-dismiss="modal"
                                    onclick="closeModal(this)">Kembali</button>
                                <button type="submit" class="btn-primary" :disabled="!fileSelected"
                                    :class="{ 'opacity-50 cursor-not-allowed': !fileSelected }">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            console.log('skkkUploadHandler');
            Alpine.data('skkkUploadHandler', () => ({
                fileSelected: false,
                selectedFileName: '',
                errorMessage: '',
                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Check if file size exceeds 3MB (3 * 1024 * 1024 bytes)
                        if (file.size > 3 * 1024 * 1024) {
                            this.errorMessage = 'File terlalu besar! Maksimal berukuran 3MB.';
                            this.fileSelected = false;
                            this.selectedFileName = '';
                            // Clear the file input
                            event.target.value = '';
                        } else {
                            this.errorMessage = '';
                            this.fileSelected = true;
                            this.selectedFileName = file.name;
                        }
                    } else {
                        this.fileSelected = false;
                        this.selectedFileName = '';
                    }
                },
                submitForm() {
                    this.$refs.dropzone.closest('form').submit();
                }
            }));
        });
    </script>
@endpush
