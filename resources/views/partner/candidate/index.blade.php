@extends('partner._layout.main')

@section('title', 'List Kandidat')

@section('content')
    <div class="flex flex-col flex-grow w-full">
        <div class="mb-8">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Pilih Status</label>
                <select id="tabs" class="bg-white border rounded-md block w-full p-2.5">
                    <option data-status="semua" id="all-tab">Semua</option>
                    <option data-status="review_by_mitra" id="review-tab">Dalam Review</option>
                    <option data-status="accepted" id="accepted-tab">Diterima</option>
                    <option data-status="rejected_by_mitra" id="rejected-tab">Ditolak</option>
                    <option data-status="completed" id="completed-tab">Selesai</option>
                </select>
            </div>
            <ul class="hidden text-sm font-medium bg-white text-center text-gray-600 shadow sm:flex">
                <li class="w-full focus-within:z-10">
                    <a href="#" id="all-tab" class="inline-block w-full p-4 focus-4" aria-current="page"
                        data-status="semua">Semua</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="review-tab" class="inline-block w-full p-4 focus-4"
                        data-status="review_by_mitra">Dalam
                        Review</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="accepted-tab" class="inline-block w-full p-4 focus-4"
                        data-status="accepted">Diterima</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="rejected-tab" class="inline-block w-full p-4 focus-4"
                        data-status="rejected_by_mitra">Ditolak</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="completed-tab" class="inline-block w-full p-4 focus-4"
                        data-status="completed">Selesai</a>
                </li>
            </ul>
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
    @include('partner.candidate._components.detail-modal')
    @include('partner.candidate._components.delete-candidate')

    <!-- Include js -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
@endsection

@push('scripts')
    @vite(['resources/js/partners/candidate/table-candidate.js', 'resources/js/partners/candidate/modal-handler.js'])
@endpush
