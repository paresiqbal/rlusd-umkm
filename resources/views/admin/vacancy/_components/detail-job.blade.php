<div id="detailLowonganModal" class="relative z-50 modal hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <button id="closeDetailLowongan"
                        class="absolute top-4 right-4 p-1 hover:bg-gray-200 focus:outline-none rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 text-gray-900" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Detail Lowongan</h2>
                </div>
                <div id="jobModalContent" class="text-sm bg-foreground rounded-md mb-6 p-4 border">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="hidden">
                                <td class="w-[120px] p-2">Id Pekerjaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_post_job_id" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Judul Pekerjaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_role" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Deskripsi Pekerjaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_job_desc" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Jumblah SDM</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_number_sdm" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Minimal Pendidikan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_education_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Jenis Kelamin</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_genders" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Jenis Pekerjaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_job_type_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Jenis Layanan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_service_types" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Provinsi</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_province" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Kabupaten</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_district" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Kecamatan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_subdistrict" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Alamat</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_address" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Tipe Pekerjaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_employment_type_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Syarat & Kualifikasi</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_qualifications" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Kompetensi yang Dibutuhkan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_skills" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[120px] p-2">Rentang Gaji</td>
                                <td class="text-gray-800 p-2">:</td>
                                <div>
                                    <td class="text-gray-800 p-2"><span id="detail_min_salary"></span> - <span
                                            id="detail_max_salary"></span>
                                    </td>
                                </div>
                            </tr>
                            <tr class="hidden">
                                <td class="w-[120px] p-2">Status Lowongan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="detail_status" class="text-gray-800 p-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between gap-2 items-center">
                    <button id="acceptJobs"
                        class="px-4 py-2 bg-green-500 w-full text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 transition">
                        Setujui
                    </button>
                    <button id="rejectJobs"
                        class="px-4 py-2 bg-red-500 w-full text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Temporary solution to update the button visibility
    document.addEventListener('DOMContentLoaded', () => {
        const statusElement = document.getElementById('detail_status');
        if (!statusElement) return;

        const updateButtons = () => {
            const status = statusElement.textContent.trim();
            const acceptBtn = document.getElementById('acceptJobs');
            const rejectBtn = document.getElementById('rejectJobs');

            if (status === 'accepted') {
                acceptBtn?.classList.add('hidden');
            } else {
                acceptBtn?.classList.remove('hidden');
            }
            if (status === 'reject_by_admin') {
                rejectBtn?.classList.add('hidden');
            } else {
                rejectBtn?.classList.remove('hidden');
            }
        };

        updateButtons();

        const observer = new MutationObserver(updateButtons);
        observer.observe(statusElement, {
            childList: true,
            characterData: true,
            subtree: true
        });
    });
</script>
