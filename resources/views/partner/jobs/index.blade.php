@extends('partner._layout.main')

@section('title', 'List Lowongan')

@section('content')
    <div class="flex flex-col flex-grow w-full">
        <div class="mb-8">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Pilih Status</label>
                <select id="tabs" class="bg-white border rounded-md block w-full p-2.5">
                    <option data-status="semua" id="all-tab">Semua</option>
                    <option data-status="accepted" id="accepted-tab">Diterbitkan</option>
                    <option data-status="review_by_admin" id="review_by_admin-tab">Dalam Review</option>
                    <option data-status="closed" id="closed-tab">Ditutup</option>
                </select>
            </div>
            <ul class="hidden text-sm font-medium bg-white text-center text-gray-600 shadow sm:flex">
                <li class="w-full focus-within:z-10">
                    <a href="#" id="all-tab" class="inline-block w-full p-4 focus-4" aria-current="page"
                        data-status="semua">Semua</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="accepted-tab" class="inline-block w-full p-4 focus-4"
                        data-status="accepted">Diterbitkan</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="review_by_admin-tab" class="inline-block w-full p-4 focus-4"
                        data-status="review_by_admin">Dalam Review</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="closed-tab" class="inline-block w-full p-4 focus-4"
                        data-status="closed">Ditutup</a>
                </li>
            </ul>
        </div>
        <div class="mb-4">
            <button id="tambahLowongan" class="flex items-center btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Kebutuhan
            </button>
        </div>

        <div id="wrapper" class="mb-4"></div>
        <div class="flex items-center gap-4">
            <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Show rows per page</label>
            <select id="rowsPerPage" class="bg-white border border-gray-300 rounded-lg text-sm w-24 p-2.5">
                <option value="8">8</option>
                <option value="15">15</option>
            </select>
        </div>
    </div>

    <!-- Include modal -->
    @include('partner.jobs._components.add-job')
    @include('partner.jobs._components.edit-job')
    @include('partner.jobs._components.detail-job')
    @include('partner.jobs._components.delete-job')
    @include('partner.jobs._components.tutup-lowongan')

    <!-- Include js -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
@endsection

@push('scripts')
    @vite(['resources/js/partners/jobs/table-jobs.js', 'resources/js/partners/jobs/modal-handler.js'])
@endpush
