@extends('admin._layout.main')

@section('title', 'Mitra')

@section('content')
    <div class="container mx-auto">
        <div class="flex flex-col w-full flex-grow">
            <div class="mb-6">
                <!-- Mobile view: dropdown for tabs -->
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select your status</label>
                    <select id="tabs" class="bg-gray-50 border border-gray-300 block w-full p-2.5">
                        <option data-status="null">Semua</option>
                        <option data-status="true">Aktif</option>
                        <option data-status="false">Tidak Aktif</option>
                    </select>
                </div>
                <!-- Desktop view: horizontal tab list -->
                <ul
                    class="hidden sm:flex text-sm font-medium bg-foreground text-center text-gray-600 shadow overflow-x-auto">
                    <li class="w-full focus-within:z-10">
                        <a href="#" id="all-tab" class="inline-block w-full p-4 focus:outline-none"
                            aria-current="page">Semua</a>
                    </li>
                    <li class="w-full focus-within:z-10">
                        <a href="#" id="aktif-tab" class="inline-block w-full p-4 focus:outline-none"
                            data-status="true">Aktif</a>
                    </li>
                    <li class="w-full focus-within:z-10">
                        <a href="#" id="tidak-aktif-tab" class="inline-block w-full p-4 focus:outline-none"
                            data-status="false">Tidak Aktif</a>
                    </li>
                </ul>
            </div>

            <!-- Responsive filter toolbar -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div>
                        <label for="provinceFilter" class="block text-sm font-medium text-gray-700">Filter Provinsi</label>
                        <select id="provinceFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="districtFilter" class="block text-sm font-medium text-gray-700">Filter Kabupaten</label>
                        <select id="districtFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('admin.partners.download') }}"
                        class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                        Download Mitra Data
                    </a>
                </div>
            </div>

            <!-- Wrapper for the dynamic Grid.js table with overflow support for smaller screens -->
            <div id="wrapper" class="mb-4 overflow-x-auto"></div>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Show rows per page</label>
                <select id="rowsPerPage" class="bg-white border rounded-lg text-sm w-24 p-2.5">
                    <option value="8">8</option>
                    <option value="15">15</option>
                </select>
            </div>
        </div>

        <!-- Include modals -->
        @include('admin.mitra._components.detail-modal')
        @include('admin.mitra._components.block-modal')
        @include('admin.mitra._components.unblock-modal')
        @include('admin.mitra._components.delete-mitra-modal')

        <!-- Include Grid.js -->
        <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/admin/mitra/table-mitra.js', 'resources/js/admin/mitra/modal-handler.js', 'resources/js/admin/mitra/mitra-status.js', 'resources/js/admin/mitra/delete-mitra.js'])
@endpush
