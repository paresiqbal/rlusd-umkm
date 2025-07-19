@extends('admin._layout.main')

@section('title', 'Kandidat')

@section('content')

    <div class="flex flex-col w-full">
        <div class="mb-8">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select your status</label>
                <select id="tabs" class="bg-white border rounded-sm block w-full p-2.5">
                    <option data-status="semua">Semua</option>
                    <option data-status="review_by_admin">Diterbitkan</option>
                    <option data-status="review_by_mitra">Disetujui</option>
                    <option data-status="accepted">Diterima</option>
                    <option data-status="rejected_by_admin">Ditolak</option>
                </select>
            </div>
            <ul class="hidden text-sm font-medium bg-white text-center text-gray-600 shadow sm:flex">
                <li class="w-full focus-within:z-10">
                    <a href="#" id="all-tab" class="inline-block w-full p-4 focus-4" aria-current="page"
                        data-status="semua">Semua</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="dalam-review-admin-tab" class="inline-block w-full p-4 focus-4"
                        data-status="review_by_admin">Dalam Review</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="disetujui-tab" class="inline-block w-full p-4 focus-4"
                        data-status="review_by_mitra">Disetujui</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="diterima-tab" class="inline-block w-full p-4 focus-4"
                        data-status="accepted">Diterima</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="ditolak-tab" class="inline-block w-full p-4 focus-4"
                        data-status="reject_by_admin">Ditolak</a>
                </li>
            </ul>
        </div>

        <!-- Wrapper for the dynamic Grid.js table -->
        <div id="wrapper" class="mb-4"></div>
        <div class="flex items-center gap-4">
            <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Show rows per page</label>
            <select id="rowsPerPage" class="bg-white border border-gray-300 rounded-lg text-sm w-24 p-2.5">
                <option value="8">8</option>
                <option value="15">15</option>
            </select>
        </div>
    </div>

    <!-- Include modals -->
    @include('admin.candidate._components.detail-modal')
    @include('admin.candidate._components.delete-candidate')

    <!-- Include Grid.js -->
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
@endsection

@push('scripts')
    @vite(['resources/js/admin/candidate/table-candidate.js'])
@endpush
