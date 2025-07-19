<div class="relative z-50 modal hidden" id="{{ $modalId ?? 'partner-profile-picture-modal' }}"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">
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
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Sesuaikan Foto Anda</h3>
                        <form id="profile-picture-form" action="{{ route('partners.profile.update-photo') }}"
                            method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <img id="preview-upload-profile" class="w-full h-auto" src="" alt="Profile Picture">
                            <input type="hidden" name="cropped_data" id="cropped_data">
                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="closeModal(this)"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                                    Batal
                                </button>
                                <button type="submit" onclick="return prepareAndSubmit()"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
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

{{-- script for profile picture change --}}
<script>
    const inputId = "{{ $inputId ?? 'input-profile-picture' }}";
    let cropper = null;

    function onProfilePictureButtonClick(e) {
        document.querySelector(`#${inputId}`).click()
    }

    function onProfilePictureFileChanged(e) {
        const input = document.querySelector(`#${inputId}`);
        const imgPreview = document.querySelector('#preview-upload-profile');
        const file = e.files[0];
        openModal(input);

        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader()

                reader.onload = function(e) {
                    imgPreview.src = e.target.result
                    imgPreview.style.display = 'block'

                    // Destroy existing cropper if it exists
                    if (cropper) {
                        cropper.destroy();
                    }

                    // Initialize Cropper
                    cropper = new Cropper(imgPreview, {
                        aspectRatio: 1,
                        viewMode: 1,
                        background: false,
                        autoCropArea: 1,
                        autoCrop: true,
                    });
                }
                reader.readAsDataURL(file)
            } else {
                alert('Mohon pilih file gambar');
            }
        }
    }

    function closeModal(element) {
        const modal = element.closest('.modal');
        modal.classList.add('hidden');

        // Destroy cropper instance when modal is closed
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function prepareAndSubmit() {
        if (!cropper) {
            alert('Mohon pilih gambar terlebih dahulu');
            return false;
        }

        // Get the cropped canvas
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });

        // Convert to base64 and store in hidden input
        const croppedData = canvas.toDataURL('image/jpeg', 0.8);
        document.getElementById('cropped_data').value = croppedData;

        return true;
    }
</script>

<style>
    .spinner {
        display: inline-block;
        width: 1em;
        height: 1em;
        border: 2px solid #ffffff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
