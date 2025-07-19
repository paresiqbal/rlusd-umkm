<section id="lamaran" class="hidden tab-pane">
    <div class="flex flex-col w-full lex-grow">
        <div class="mb-6">
            <ul id="tabs" class="hidden text-sm font-medium bg-foreground text-center text-gray-600 shadow sm:flex">
                <li class="w-full focus-within:z-10">
                    <a href="#" data-status="all" class="inline-block w-full p-4 focus-4">Semua</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" data-status="review_by_admin" class="inline-block w-full p-4 focus-4">Dalam
                        Review</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" data-status="accepted" class="inline-block w-full p-4 focus-4">Diterima</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" data-status="completed" class="inline-block w-full p-4 focus-4">Selesai</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" data-status="rejected_by_admin"
                        class="inline-block w-full p-4 focus-4">Ditolak</a>
                </li>
            </ul>
            <!-- Mobile tabs -->
            <div class="sm:hidden">
                <select id="mobile-tabs"
                    class="w-full rounded-md p-4 text-sm font-medium bg-foreground text-gray-600 shadow">
                    <option value="all">Semua</option>
                    <option value="review_by_admin">Dalam Review</option>
                    <option value="accepted">Diterima</option>
                    <option value="completed">Selesai</option>
                    <option value="rejected_by_admin">Ditolak</option>
                </select>
            </div>
        </div>

        <!-- Cards container -->
        <div id="cards-container">
            @foreach ($applications as $application)
                @php
                    // dd($application->job->user->partnerProfile);
                    [$formattedStatus, $statusClass] = formatStatus($application->status);

                    $partnerProfile = $application->job->user->partnerProfile;
                    $photoUrl = optional($partnerProfile->photoProfile)->url ?? asset('assets/img/default-avatar.jpg');
                @endphp
                <div class="bg-white shadow rounded-lg p-6 mb-4" data-status="{{ $application->status }}">
                    <div class="flex gap-4 pb-4 items-center">
                        <img src="{{ optional($application->job->user->partnerProfile->photoProfile)->public_url ?? asset('assets/img/default-avatar.jpg') }}"
                            alt="company logo" class="w-10 h-10 rounded-full">
                        <div>
                            <h3 class="text-lg font-medium mt-2">
                                {{ $application->job->user->partnerProfile->partner_name }}</h3>
                            <p>{{ $application->created_at }}</p>
                        </div>
                        <p class="ml-auto rounded-lg px-2 py-1 {{ $statusClass }}">{{ $formattedStatus }}</p>
                    </div>
                    <div>
                        <p class="block text-lg font-semibold">{{ $application->job->role }}</p>
                        <span class="flex items-center gap-4">
                            <div class="h-1 w-1 rounded-full bg-gray-800"></div>
                            <p>{{ $application->job->jobType->job_type_name }}</p>
                        </span>
                        <span class="flex items-center gap-4">
                            <div class="h-1 w-1 rounded-full bg-gray-800"></div>
                            <p>{{ $application->job->employmentType->employment_type_name }}</p>
                        </span>
                    </div>
                    <div class="mt-4 text-gray-500 flex gap-4">
                        <span class="flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                <path
                                    d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                            </svg>
                            {{ $application->job->district->district_name }},
                            {{ $application->job->province->province_name }}
                        </span>
                        <div class="flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-wallet">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                                <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                            </svg>
                            Rp{{ number_format($application->job->min_salary, 0, ',', '.') }} -
                            Rp{{ number_format($application->job->max_salary, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination controls -->
        <div class="flex flex-col sm:flex-row justify-between mt-4 items-center">
            <div class="flex items-center gap-4 mt-4">
                <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Show rows per page</label>
                <select id="rowsPerPage" class="bg-white border rounded-lg text-sm w-24 p-2.5">
                    <option value="2">2</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="flex gap-2 mt-4 sm:mt-0 items-center">
                <span id="line-info" class="text-sm font-medium text-gray-700"></span>
                <button id="prev-btn" class="text-gray-700 px-4 py-2 rounded"> <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <button id="next-btn" class="text-gray-700 px-4 py-2 rounded"> <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    @vite(['resources/js/user/user-applications.js'])
    <script>
        document.getElementById('mobile-tabs').addEventListener('change', function() {
            const status = this.value;
            document.querySelectorAll('#tabs a').forEach(tab => {
                if (tab.dataset.status === status) {
                    tab.click();
                }
            });
        });
    </script>
@endpush

@php
    function formatStatus($status)
    {
        switch ($status) {
            case 'review_by_admin':
                return ['Menunggu', 'bg-[#007AFF] text-white'];
            case 'review_by_mitra':
                return ['Menunggu', 'bg-[#007AFF] text-white'];
            case 'accepted':
                return ['Diterima', 'bg-[#3CB059] text-white'];
            case 'completed':
                return ['Selesai', 'bg-[#808080] text-white'];
            case 'rejected':
                return ['Ditolak', 'bg-[#FF3B30] text-white'];
            case 'rejected_by_admin':
                return ['Ditolak', 'bg-[#FF3B30] text-white'];
            case 'rejected_by_mitra':
                return ['Ditolak', 'bg-[#FF3B30] text-white'];
            default:
                return ['Tidak diketahui', 'bg-gray-200 text-gray-800'];
        }
    }
@endphp
