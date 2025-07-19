@extends('partner._layout.main')

@section('title', $pageTitle)

@section('content')

    <div class="bg-white rounded-md shadow p-4">
        <div class="flex items-center mb-4 gap-2">
            {{-- Display freelancer image if available, else default --}}
            @if ($freelancer->freelancerProfile->photoProfile)
                <img src="{{ $freelancer->freelancerProfile->photoProfile->public_url }}" alt="Profile Picture"
                    class="w-24 h-24 rounded-full">
            @else
                <img src="/assets/img/default-avatar.jpg" alt="Profile Picture" class="w-24 h-24">
            @endif
            <div>
                <p class="text-2xl font-semibold">{{ $freelancer->freelancerProfile->name }}</p>
                <p class="mb-2">{{ $freelancer->email }}</p>
            </div>
        </div>
        <div>
            <p class="font-semibold">Tentang</p>
            <p class="mb-4">
                {{ $freelancer->freelancerProfile->about_me ?? 'N/A' }}
            </p>
        </div>
        <div class="mb-4">
            <p class="font-semibold">Dokumen</p>
            <ul class="list-disc pl-4">
                @if ($freelancer->freelancerProfile->fileSKKNI)
                    <li>
                        <a href="{{ route('users.profiles.skkni.show') }}" class="text-blue-500 hover:underline">
                            SKKNI Certificate
                        </a>
                    </li>
                @endif
                @if ($freelancer->freelancerProfile->fileSKKK)
                    <li>
                        <a href="{{ route('users.profiles.skkk.show') }}" class="text-blue-500 hover:underline">
                            SKKK Certificate
                        </a>
                    </li>
                @endif
                @if (
                    !$freelancer->freelancerProfile->fileCV &&
                        !$freelancer->freelancerProfile->fileSKKNI &&
                        !$freelancer->freelancerProfile->fileSKKK)
                    <li>N/A</li>
                @endif
            </ul>
        </div>
        <div>
            <p class="font-semibold">Keahlian</p>
            <ul class="mb-2 list-disc pl-4">
                @if ($freelancer->freelancerProfile->skills->isNotEmpty())
                    @foreach ($freelancer->freelancerProfile->skills as $skill)
                        <li>{{ $skill->skill_name }}</li>
                    @endforeach
                @else
                    <li>N/A</li>
                @endif
            </ul>
        </div>
    </div>

    <a href="{{ route('partners.freelancers.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">
        &laquo; Back to List
    </a>

@endsection
