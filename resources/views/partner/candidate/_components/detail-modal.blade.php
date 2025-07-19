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
                                <td class="text-gray-700 p-2">Tanggal Lahir</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_birthdate" class="text-gray-800 p-2"></td>
                            </tr>
                            <tr>
                                <td class="text-gray-700 p-2">Usia</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_age" class="text-gray-800 p-2"></td>
                            </tr>
                            {{-- <tr>
                                <td class="text-gray-700 p-2">Alamat</td>
                                <td class="text-gray-800 p-2">:</td>
                                <td id="candidate_address" class="text-gray-800 p-2"></td>
                            </tr> --}}
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
                        class="px-4 py-2 bg-green-500 hidden w-full text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 transition">
                        Terima
                    </button>
                    <button id="rejectCandidate"
                        class="px-4 py-2 bg-red-500 hidden w-full text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-600 transition">
                        Tolak
                    </button>
                    <button id="completedCandidate"
                        class="px-4 py-2 bg-green-500 w-full hidden text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600 transition">
                        Selesai Pekerjaan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusCell = document.getElementById('candidate_status');
        const acceptButton = document.getElementById('acceptCandidate');
        const rejectButton = document.getElementById('rejectCandidate');
        const completedButton = document.getElementById('completedCandidate');

        // Function to update button based on status
        function updateButton() {
            const status = statusCell.textContent.trim().toLowerCase();
            if (status === 'accepted') {
                acceptButton.style.display = 'none';
                rejectButton.style.display = 'none';
                completedButton.style.display = 'block'; // Hide reject button
            } else if (status === 'rejected_by_mitra') {
                acceptButton.style.display = 'block';
                rejectButton.style.display = 'none';
                // ...existing code remains unchanged (completedButton remains as is)...
            } else {
                acceptButton.style.display = 'block';
                rejectButton.style.display = 'block';
            }
        }

        // Create a MutationObserver to watch for changes in the status cell
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(updateButton);
        });

        // Start observing the status cell
        observer.observe(statusCell, {
            childList: true,
            subtree: true,
            characterData: true
        });
    });
</script>
