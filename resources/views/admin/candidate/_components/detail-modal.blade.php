<div id="detailCandidateModal" class="relative z-50 modal hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay"></div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
            <div class="relative p-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-lg font-semibold">Detail Kandidat</p>
                    <button id="closeCandidateModal"
                        class="absolute top-4 right-4 p-1 hover:bg-gray-200 focus:outline-none rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 text-gray-900" viewBox="0 0 24 24">
                            <path d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="candidateModalContent" class="text-sm bg-foreground rounded-md mb-6 p-4 border">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr class="hidden">
                                <td class="w-[180px] text-gray-700 p-2">Id Freelancer</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="application_id" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-800 p-2">
                                    <img id="profilePicture" src="/assets/img/default-avatar.jpg"
                                        class="rounded-full w-20 h-20" alt="Profile Picture" />
                                </td>
                            </tr>
                            <tr>
                                <td class="w-[180px] text-gray-700 p-2">Nama Konsultan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_name" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Email</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_email" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Usia</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_birthdate" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Alamat</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_address" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">No Wa</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_phone" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">CV</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td class="text-gray-800 p-2"> <a id="candidate_resume" href="#" target="_blank"
                                        class="underline"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Dokumen SKKNI</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td class="text-gray-800 p-2"> <a id="candidate_skkni" href="#" target="_blank"
                                        class="underline"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Dokumen SKKK</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td class="text-gray-800 p-2"> <a id="candidate_skkk" href="#" target="_blank"
                                        class="underline"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Tentang</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_about" class="text-gray-800 p-2">N/A</td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Pendidikan</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_education" class="text-gray-800 p-2">N/A</td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Pengalaman</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_experience" class="text-gray-800 p-2">N/A</td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Keahlian</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_skills" class="text-gray-800 p-2">N/A</td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Status</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_status" class="text-gray-800 p-2">N/A</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between gap-2 items-center">
                    <button id="acceptCandidate"
                        class="px-4 py-2 bg-green-500 w-full text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 transition">
                        Terima
                    </button>
                    <button id="rejectCandidate"
                        class="px-4 py-2 bg-red-500 w-full text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                        Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const candidateStatus = document.getElementById('candidate_status');
        const acceptButton = document.getElementById('acceptCandidate');
        const rejectButton = document.getElementById('rejectCandidate');

        function toggleCandidateActionButtons() {
            const status = candidateStatus.textContent.trim();
            // Show buttons only if the status is 'review_by_admin' or 'rejected_by_admin'
            if (status === 'review_by_admin' || status === 'rejected_by_admin') {
                acceptButton.style.display = '';
                rejectButton.style.display = '';
            } else {
                acceptButton.style.display = 'none';
                rejectButton.style.display = 'none';
            }
        }

        // Ensure function runs after content is updated
        toggleCandidateActionButtons();

        // If the content is updated dynamically, observe the status changes
        const observer = new MutationObserver(toggleCandidateActionButtons);
        observer.observe(candidateStatus, {
            childList: true
        });
    });
</script>
