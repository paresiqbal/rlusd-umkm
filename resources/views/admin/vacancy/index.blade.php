@extends('admin._layout.main')

@section('title', 'Lowongan')

@section('content')
    <div class="flex flex-col w-full lex-grow">
        <div class="mb-8">
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Pilih Status</label>
                <select id="tabs" class="bg-white border rounded-md block w-full p-2.5">
                    <option data-status="semua" id="all-tab">Semua</option>
                    <option data-status="publish" id="publish-tab">Belum Disetujui</option>
                    <option data-status="draft" id="draft-tab">Disetujui</option>
                </select>
            </div>
            <ul class="hidden text-sm font-medium bg-white text-center text-gray-600 shadow sm:flex">
                <li class="w-full focus-within:z-10">
                    <a href="#" id="all-tab" class="inline-block w-full p-4 focus-4" aria-current="page"
                        data-status="semua">Semua</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="review-tab" class="inline-block w-full p-4 focus-4"
                        data-status="review_by_admin">Belum
                        Disetujui</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="accepted-tab" class="inline-block w-full p-4 focus-4"
                        data-status="accepted">Disetujui</a>
                </li>
                <li class="w-full focus-within:z-10">
                    <a href="#" id="reject_by_admin-tab" class="inline-block w-full p-4 focus-4"
                        data-status="reject_by_admin">Ditolak</a>
                </li>
            </ul>
        </div>

        <!-- Wrapper for the dynamic Grid.js table -->
        <div id="wrapper" class="mb-4"></div>
        <div class="flex items-center gap-4">
            <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Show rows per page</label>
            <select id="rowsPerPage" class="bg-white border rounded-lg text-sm w-24 p-2.5">
                <option value="8">8</option>
                <option value="15">15</option>
            </select>
        </div>
    </div>

    <!-- Include modals -->
    @include('admin.vacancy._components.detail-job')
    @include('admin.vacancy._components.delete-job')

    <!-- Include Grid.js -->
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
@endsection

@push('scripts')
    @vite(['resources/js/admin/vacancy/table-vacancy.js', 'resources/js/admin/vacancy/modal-handler.js'])
@endpush
