<div class="p-4 rounded border border-gray-50 lg:w-[48%]">
    <div class="flex items-center gap-2">
        @if ($job->user->partnerProfile->logoFile)
            <img src="{{ $job->user->partnerProfile->logoFile->public_url }}" alt="Logo Perusahaan"
                class="size-12 rounded-full">
        @else
            <img src="{{ asset('assets/img/default-avatar.jpg') }}" alt="Logo Perusahaan" class="size-12">
        @endif
        <div class="flex flex-col justify-evenly">
            <span class="font-semibold text-lg">{{ $job->user->partnerProfile->partner_name }}</span>
            <span class="text-gray-500 text-xs">
                {{ Carbon\Carbon::parse($job->created_at)->locale('id')->diffForHumans() }}
            </span>
        </div>
    </div>
    <div class="mt-4">
        <span class="block text-lg font-semibold">{{ $job->role }}</span>
        <span class="text-base text-gray-500 block mt-2">
            <ul class="px-4">
                <li class="list-disc">{{ $job->employmentType->employment_type_name }}</li>
                <li class="list-disc">{{ $job->jobType->job_type_name }}</li>
            </ul>
        </span>
    </div>
    <div class="mt-4 text-gray-500 flex flex-col gap-2">
        <div class="flex gap-2 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
            </svg>
            {{ $job->district->district_name }}, {{ $job->province->province_name }}
        </div>
        @if (!$job->is_hidden_salary)
            <div class="flex gap-2 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-wallet">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                    <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                </svg>
                Rp{{ number_format($job->min_salary, 2, ',', '.') }} -
                Rp{{ number_format($job->max_salary, 2, ',', '.') }}
            </div>
        @endif
    </div>
    <div class="mt-4 flex flex-col gap-2">
        <a href="{{ route('users.jobs.show', ['id' => $job->post_job_id]) }}" class="btn-outlined">
            Detail Pekerjaan
        </a>
    </div>
</div>
