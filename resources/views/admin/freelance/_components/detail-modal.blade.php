<div id="detailFreelancerModal" class="relative z-50 modal hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <button id="closeDetailFreelancer"
                        class="absolute top-4 right-4 p-1 hover:bg-gray-200 focus:outline-none rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 text-gray-900" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Detail Konsultan</h2>
                </div>
                <div id="modalContent" class="text-sm bg-gray-50/40 rounded-md mb-6 p-4 border">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="hidden">
                                <td class="w-[180px] text-gray-700 p-2">Id Freelancer</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelancer_id" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-800 p-2">
                                    <img id="profilePicture" src="/assets/img/default-avatar.jpg"
                                        class="rounded-full w-20 h-20" alt="Profile Picture" />
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Nama Konsultan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Tentang</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_about" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Email Konsultan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_email" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Tanggal Lahir</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_birthdate" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">Alamat</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_address" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="w-[200px] text-gray-700 p-2">No WA</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_phone_number" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">CV</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td class="text-gray-800 p-2"> <a id="freelance_resume" href="#" target="_blank"
                                        class="underline"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Dokumen SKKNI</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td class="text-gray-800 p-2"> <a id="freelance_skkni" href="#" target="_blank"
                                        class="underline"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Dokumen SKKK</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td class="text-gray-800 p-2"> <a id="freelance_skkk" href="#" target="_blank"
                                        class="underline"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Pendidikan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_education" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Pengalaman</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_experience" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Prestasi</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_achievement" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Keahlian</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="freelance_skill" class="text-gray-800 p-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
