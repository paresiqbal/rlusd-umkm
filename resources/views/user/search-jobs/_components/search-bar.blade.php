<form method="GET" action="{{ route('users.jobs.index-search') }}" class="flex items-center w-full">
    <!-- Search Input -->
    <input type="text" name="search"
        class="grow py-2 px-4 border rounded-tl-full rounded-bl-full border-gray-100 focus:border-primary-500 focus:outline-none focus:ring-0"
        placeholder="Cari pekerjaan" value="{{ request('search') }}">

    <!-- Search Button -->
    <button type="submit"
        class="btn-primary border border-primary-500 rounded-tl-none rounded-bl-none rounded-tr-full rounded-br-full">
        <!-- SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icon-tabler-search">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0-14 0" />
            <path d="M21 21l-6-6" />
        </svg>
    </button>
</form>
