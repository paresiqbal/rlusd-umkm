@extends('common._layout.main-user')

@section('title', 'Detail Pekerjaan')

@section('content')
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-8">
        <div class="lg:grow">
            <p class="font-bold text-xl ">{{ $job->role }}</p>
            <div class="flex items-center gap-2 text-gray-500 mt-2">
                <p>{{ $job->user->partnerProfile->partner_name }}</p>
                <div class="size-1 bg-gray-500 rounded-full"></div>
                <p>Diposting {{ Carbon\Carbon::parse($job->created_at)->locale('id')->diffForHumans() }}</p>
            </div>
            @php
                $alreadyApplied = $job->applications->contains('applicant_id', auth()->user()->user_id);
            @endphp
            @if (!$alreadyApplied)
                <button class="apply-job-btn btn-primary mt-2" data-job-id="{{ $job->post_job_id }}">
                    Lamar Sekarang
                </button>
            @else
                <button class="btn-secondary mt-2" disabled>Anda sudah melamar pekerjaan ini</button>
            @endif
            <div class="mt-8">
                <p class="font-bold">Deskripsi Pekerjaan</p>
                <p class="mt-4 text-justify">
                    {{ $job->job_desc }}
                </p>
            </div>
            <div class="mt-8">
                <p class="font-bold">Kategori</p>
                <p class="mt-4 text-justify">
                <ul class="ml-4">
                    <li class="list-disc">
                        {{ $job->employmentType->employment_type_name }}
                    </li>
                </ul>
                </p>
            </div>
            <div class="mt-8">
                <p class="font-bold">Minimal Pendidikan</p>
                <p class="mt-4 text-justify">
                <ul class="ml-4">
                    <li class="list-disc">{{ $job->education->education_name }}</li>
                </ul>
                </p>
            </div>
            @if (!$job->is_hidden_salary)
                <div class="mt-8">
                    <p class="font-bold">Rentang Gaji</p>
                    <p class="mt-4 text-justify">
                    <ul class="ml-4">
                        <li class="list-disc">
                            Rp{{ number_format($job->min_salary, 2, ',', '.') }}
                            -
                            Rp{{ number_format($job->max_salary, 2, ',', '.') }}
                        </li>
                    </ul>
                    </p>
                </div>
            @endif

            <div class="mt-8">
                <p class="font-bold">Tipe Pekerjaan</p>
                <p class="mt-4 text-justify">
                <ul class="ml-4">
                    <li class="list-disc">{{ $job->jobType->job_type_name }}</li>
                </ul>
                </p>
            </div>
            <div class="mt-8">
                <p class="font-bold">Syarat dan Kualifikasi</p>
                <p class="mt-4 text-justify">
                    {!! Illuminate\Support\Str::replace('- ', '<br>- ', $job->qualifications) !!}
                </p>
            </div>
            <div class="mt-8">
                <p class="font-bold">Keahlian yang Dibutuhkan</p>
                <p class="mt-4 text-justify">
                <ul class="ml-4">
                    @foreach ($job->skills as $skill)
                        <li class="list-disc">{{ $skill->skill_name }}</li>
                    @endforeach
                </ul>
                </p>
            </div>
            @if (!$alreadyApplied)
                <button class="apply-job-btn btn-primary mt-2" data-job-id="{{ $job->post_job_id }}">
                    Lamar Sekarang
                </button>
            @endif
        </div>
        <div class="mt-8 lg:mt-0 lg:w-3/12 shrink-0">
            <div class="rounded border border-gray-50 p-4">
                <div class="flex items-center gap-4">
                    @if ($partner->logoFile)
                        <img src="{{ $partner->logoFile->public_url }}" alt="Logo Perusahaan" class="size-16 rounded-full">
                    @else
                        <img src="{{ asset('assets/img/default-avatar.jpg') }}" alt="Logo Perusahaan"
                            class="size-16 rounded-full">
                    @endif
                    <div class="flex flex-col justify-evenly">
                        <p class="font-bold text-xl">{{ $partner->partner_name }}</p>
                        <a href="{{ \Illuminate\Support\Str::startsWith($partner->website, ['http://', 'https://']) ? $partner->website : 'https://' . $partner->website }}"
                            target="_blank"
                            class="text-gray-500 underline text-sm hover:text-gray-600 active:text-gray-700 underline-offset-4">
                            Kunjungi Website
                        </a>
                    </div>
                </div>
                <div class="border-t-2 border-gray-100 mt-4"></div>
                <div class="text-justify mt-4">
                    {{ $partner->about_company }}
                </div>
                <div class="mt-4 flex gap-2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                    </svg>
                    {{ $partner->address }}
                </div>
            </div>
        </div>
    </div>

    @include('user.job-detail._components.lamar')
@endsection

@push('scripts')
    @vite(['resources/js/user/jobs/apply-job.js'])
@endpush
