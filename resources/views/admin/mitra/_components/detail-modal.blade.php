<div id="detailMitraModal" class="relative z-50 modal hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <button id="closeDetailMitra"
                        class="absolute top-4 right-4 p-1 hover:bg-gray-200 focus:outline-none rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 text-gray-900" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Detail Mitra</h2>
                </div>
                <div id="modalContent" class="text-sm bg-gray-50/40 rounded-md mb-6 p-4 border">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="hidden">
                                <td class="w-[180px] text-gray-700 p-2">Id Mitra</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="mitra_id" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-800 p-2">
                                    <img id="profilePicture" src="/assets/img/default-avatar.jpg"
                                        class="rounded-full w-20 h-20" alt="Profile Picture" />
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Nama Perusahaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="company_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Tentang Perusahaan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="about_company" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Email</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="company_email" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">No Wa</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="phone_number" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Alamat</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="company_address" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Nama Narahubung</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="pic_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Email Narahubung</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="pic_email" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">No Narahubung</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="pic_phone_number" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Jabatan Narahubung</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="pic_position" class="text-gray-800 p-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
