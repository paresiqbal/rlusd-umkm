@php
    $navItems = [
        [
            'label' => 'Dashboard',
            'icon' =>
                '<img src="' . asset('assets/icons/sidebar/dashboard.svg') . '" class="h-5 w-5" alt="Dashboard Icon">',
            'href' => route('admin.dashboard'),
        ],
        [
            'label' => 'Mitra',
            'icon' =>
                '<img src="' . asset('assets/icons/sidebar/mitra.svg') . '" class="h-5 w-5" alt="Dashboard Icon">',
            'dropdownItems' => [
                ['label' => 'Lihat Mitra', 'href' => route('admin.mitra')],
                ['label' => 'Lihat Kebutuhan', 'href' => route('admin.vacancies.index')],
            ],
        ],
        [
            'label' => 'Konsultan',
            'icon' =>
                '<img src="' . asset('assets/icons/sidebar/mitra.svg') . '" class="h-5 w-5" alt="Dashboard Icon">',
            'href' => route('admin.freelance'),
            'dropdownItems' => [
                ['label' => 'Lihat Konsultan', 'href' => route('admin.freelance')],
                ['label' => 'Lihat Kandidat', 'href' => route('admin.candidates.index')],
            ],
        ],
    ];
@endphp

<div class="flex h-screen md:w-72 flex-col lg:p-4">
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
        class="inline-flex fixed items-center p-2 mt-2 ms-3 text-sm text-gray-800 rounded-lg sm:hidden hover:bg-stone-100 focus:outline-none focus:ring-2 focus:ring-white dark:text-white dark:hover:bg-yellow-500 dark:focus:ring-yellow-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 bg-stone-50 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar">
        <button id="closeSidebarBtn"
            class="absolute top-4 right-4 z-50 p-2 text-gray-800 hover:bg-gray-100 rounded-lg sm:hidden">
        </button>

        <div class="h-full px-3 py-4 overflow-y-auto">
            <a href="/admin/dashboard" class="flex items-center ps-2.5 mb-5">
                <img src="/assets/img/rlusd.png" class="h-6 me-3 sm:h-7" alt="RLUSD Logo" />
                <p class="font-bold text-xl">RLUSD</p>
            </a>
            @foreach ($navItems as $item)
                <div class="mb-2">
                    {{-- Parent Item --}}
                    @if (isset($item['dropdownItems']))
                        <button onclick="toggleDropdown('{{ $item['label'] }}')"
                            class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-gray-900 hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                {!! $item['icon'] !!}
                                <span>{{ $item['label'] }}</span>
                            </div>
                            <svg id="chevron-{{ $item['label'] }}" class="h-4 w-4 transition-transform"
                                style="transform: rotate(0deg);">
                                <img src="{{ asset('assets/icons/sidebar/chevron-down.svg') }}" class="h-5 w-5"
                                    alt="Chevron Icon">
                            </svg>
                        </button>
                    @else
                        <a href="{{ $item['href'] ?? '#' }}"
                            class="flex w-full items-center rounded-lg px-3 py-2 my-4 text-gray-900 hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                {!! $item['icon'] !!}
                                <span>{{ $item['label'] }}</span>
                            </div>
                        </a>
                    @endif

                    {{-- Dropdown Items --}}
                    @if (isset($item['dropdownItems']))
                        <div id="dropdown-{{ $item['label'] }}" class="ml-9 mt-1 space-y-1 hidden">
                            @foreach ($item['dropdownItems'] as $dropdownItem)
                                <a href="{{ $dropdownItem['href'] }}"
                                    class="block rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    {{ $dropdownItem['label'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </aside>
</div>

<script>
    const toggleButton = document.querySelector('[data-drawer-toggle="logo-sidebar"]');

    const sidebar = document.getElementById('logo-sidebar');
    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    const closeBtn = document.getElementById('closeSidebarBtn');
    closeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sidebar.classList.add('-translate-x-full');
    });

    function toggleDropdown(label) {
        const dropdown = document.getElementById(`dropdown-${label}`);
        const chevron = document.getElementById(`chevron-${label}`);
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            dropdown.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
    }
</script>
