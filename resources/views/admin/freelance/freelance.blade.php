@extends('admin._layout.main')

@section('title', 'Freelance')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex flex-col w-full flex-grow">
            <div class="mb-6">
                <!-- For mobile view: a select dropdown -->
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select your status</label>
                    <select id="tabs" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option data-status="null">Semua</option>
                        <option data-status="true">Aktif</option>
                        <option data-status="false">Tidak Aktif</option>
                    </select>
                </div>
                <!-- For larger screens: a horizontal tab list -->
                <ul
                    class="hidden sm:flex sm:text-sm sm:font-medium sm:bg-foreground sm:text-center sm:text-gray-600 sm:shadow overflow-x-auto">
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
                    <!-- New filter for Main Skill -->
                    <div>
                        <label for="mainSkillFilter" class="block text-sm font-medium text-gray-700">Filter Main
                            Skill</label>
                        <select id="mainSkillFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua</option>
                            <option value="pendamping">Pendamping</option>
                            <option value="konsultan">Konsultan</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('admin.freelancers.download') }}"
                        class="bg-primary-500 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">
                        Download Konsultan Data
                    </a>
                </div>
            </div>

            <!-- Wrapper for the dynamic Grid.js table; allows horizontal scrolling on small screens -->
            <div id="wrapper" class="mb-4 overflow-x-auto"></div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <label for="rowsPerPage" class="text-sm font-medium text-gray-700">Show rows per page</label>
                <select id="rowsPerPage" class="bg-white border rounded-lg text-sm w-24 p-2.5">
                    <option value="8">8</option>
                    <option value="15">15</option>
                </select>
            </div>
        </div>

        <!-- Include modals -->
        @include('admin.freelance._components.detail-modal')
        @include('admin.freelance._components.block-modal')
        @include('admin.freelance._components.unbock-modal')
        @include('admin.freelance._components.delete-freelancer-modal')

        <!-- Include Grid.js -->
        <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/admin/freelance/table-freelance.js', 'resources/js/admin/freelance/modal-handler.js', 'resources/js/admin/freelance/freelancer-status.js'])
@endpush
