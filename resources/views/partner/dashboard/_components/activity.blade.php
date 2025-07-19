<section class="flex flex-col md:flex-row justify-between space-y-4 md:space-y-0">
    <div
        class="flex items-center space-x-4 md:space-x-28 justify-center py-10 px-6 bg-white rounded-md shadow-md w-full md:w-auto">
        <div class="font-semibold space-y-2 text-center md:text-left">
            <p class="text-xl">Lowongan diupload</p>
            <p class="text-2xl">{{ $jobCount }} Lowongan</p>
        </div>
        <img src="{{ asset('/assets/icons/stack.svg') }}" alt="Stack" class="h-14 w-14" />
    </div>
    <div
        class="flex items-center space-x-4 md:space-x-28 justify-center py-10 px-6 bg-white rounded-md shadow-md w-full md:w-auto">
        <div class="font-semibold space-y-2 text-center md:text-left">
            <p class="text-xl">Kandidat Melamar</p>
            <p class="text-2xl">{{ $totalApplicants }} Kandidat</p>
        </div>
        <img src="{{ asset('/assets/icons/kandidat.svg') }}" alt="Kandidat" class="h-14 w-14" />
    </div>
    <div
        class="flex items-center space-x-4 md:space-x-28 justify-center py-10 px-6 bg-white rounded-md shadow-md w-full md:w-auto">
        <div class="font-semibold space-y-2 text-center md:text-left">
            <p class="text-xl">Pekerjaan Selesai</p>
            <p class="text-2xl">{{ $completeApplication }} Pekerjaan</p>
        </div>
        <img src="{{ asset('/assets/icons/pekerjaan.svg') }}" alt="Pekerjaan" class="h-14 w-14" />
    </div>
</section>
