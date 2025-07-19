@extends('common._layout.main-user')

@section('title', 'Lengkapi Profil')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    @endif
    <div class="w-full">
        <h2 class="font-bold">Dashboard</h2>
        <hr class="my-4 border-gray-500">
    </div>
    <div class="flex flex-col md:flex-row w-full">
        <!-- Tab Navigation (15% width) -->
        <div class="flex flex-row md:flex-col items-start mb-6 w-full md:w-[15%]">
            <button class="px-4 py-2 font-semibold tab-button active w-full text-left hover:bg-gray-100" data-tab="data-diri">
                Data Diri
            </button>
            <button class="px-4 py-2 font-semibold tab-button w-full text-left hover:bg-gray-100" data-tab="lamaran">
                Aktifitas Lamaran
            </button>
        </div>

        <!-- Tab Content (85% width) -->
        <div class="tab-content w-full md:w-[85%] lg:p-4">
            <!-- Data Diri Tab -->
            @include('user.profiles._components.personal-data')

            <!-- Aktifitas Lamaran Tab -->
            @include('user.profiles._components.application-activity')
        </div>
    </div>

    {{-- modal component --}}

    @include('user.profiles._components.modals.personal-data', [
        'user' => $user,
        'districts' => $districts,
        'provinces' => $provinces,
    ])

    @include('user.profiles._components.modals.about-me', ['about_me' => $user->profile->about_me])

    @include('user.profiles._components.modals.work-experience-edit', [
        'experiences' => $user->profile->experiences,
    ])
    @include('user.profiles._components.modals.work-experience-form')

    @include('user.profiles._components.modals.education-edit')
    @include('user.profiles._components.modals.education-form')

    @include('user.profiles._components.modals.achievement-form')
    @include('user.profiles._components.modals.achievement-edit')

    @include('user.profiles._components.modals.skill-form')

    @include('user.profiles._components.modals.delete-confirmation')

    @include('user.profiles._components.modals.photo-profile', [
        'inputId' => 'input-profile-picture',
        'modalId' => 'user-profile-picture-modal',
    ])

    @include('user.profiles._components.modals.cv-form')
    @include('user.profiles._components.modals.skkni-form')
    @include('user.profiles._components.modals.skkk-form')
    {{-- modal component end --}}

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- Script for modal based on URL hash --}}
    <script>
        // history.pushState(null, '', '#blablabla');

        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash
            if (hash) {
                document.querySelector(`[data-tw-target="${hash}"]`)?.click()
            }
        });
    </script>
    <script>
        // Tab Switching Logic
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active classes
                document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active',
                    'border-primary-500'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.add('hidden'));

                // Add active classes
                this.classList.add('active', 'border-primary-500');
                const targetTab = document.getElementById(this.dataset.tab);
                targetTab.classList
                    .remove('hidden');
            });
        });
    </script>
    <style>
        .tab-button {
            transition: all 0.3s ease;
            border-left: 2px solid transparent;
        }

        .tab-button.active {
            border-left-color: #FA9302;
            background-color: #F9FAFB;
        }
    </style>
@endpush
