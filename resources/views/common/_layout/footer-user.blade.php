<footer class="flex flex-col px-6 py-4 bg-white md:px-16">
    {{-- FOOTER CONTENT - START --}}
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-5 md:grid-cols-3 lg:gap-4">
        <div class="flex flex-col gap-4">
            <img class="h-16 w-fit" src="/assets/img/rlusd.png">
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-2"><i class="text-gray-500 ti ti-map-pin"></i>Yogyakarta</div>
                <div class="flex items-center gap-2"><i class="text-gray-500 ti ti-brand-whatsapp"></i>+62 822 4173 3338
                </div>
                <div class="flex items-center gap-2"><i class="text-gray-500 ti ti-at"></i>sekretariat@abdsi.id</div>
            </div>
        </div>
        <div class="flex flex-col gap-4 text-16">
            <h3 class="text-sm">
                Perusahaan
            </h3>
            <div class="flex flex-col gap-3">
                <a class="font-bold text-gray-500 cursor-pointer w-fit hover:text-primary-500"
                    href="{{ route('users.jobs.index-search') }}">Peluang</a>
            </div>
        </div>
        <div class="flex flex-col gap-4 text-16">
            <h3 class="text-sm">
                Support
            </h3>
            <div class="flex flex-col gap-3">
                <a class="font-bold text-gray-500 cursor-pointer w-fit hover:text-primary-500">Terms & Conditions</a>
                <a class="font-bold text-gray-500 cursor-pointer w-fit hover:text-primary-500">Privacy Policy</a>
            </div>
        </div>
        <div class="block lg:hidden"></div>
        <div class="flex flex-col gap-4 text-16">
            <h3 class="text-sm">
                Social
            </h3>
            <div class="flex items-center gap-3">
                <a class="font-bold text-gray-500 cursor-pointer w-fit hover:text-primary-500"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                        <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                    </svg>
                </a>
                <a class="font-bold text-gray-500 cursor-pointer w-fit hover:text-primary-500"
                    href="https://www.facebook.com/pendampingkumkm.id?locale=id_ID "><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                    </svg>
                </a>
                <a class="font-bold text-gray-500 cursor-pointer w-fit hover:text-primary-500"
                    href="https://www.instagram.com/asosiasibdsindonesia/"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-instagram">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 8a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        <path d="M16.5 7.5v.01" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="flex flex-col gap-4 text-16">
            <h3 class="text-sm">
                Download
            </h3>
            <div class="flex items-center gap-3">
                <a class="cursor-pointer">
                    <img class="w-32 h-auto" src="/assets/img/app-store.png" alt="Download on App Store">
                </a>
                <a class="cursor-pointer">
                    <img class="w-32 h-auto" src="/assets/img/google-play.png" alt="Download on Google Play">
                </a>
            </div>
        </div>
    </div>
    {{-- FOOTER CONTENT - END --}}
    {{-- FOOTER COPYRIGHT - START --}}
    <div class="p-4 mt-4 text-center text-gray-800 text-16">
        ©
        <script>
            document.write(new Date().getFullYear());
        </script>
        ABDSI.
    </div>
    {{-- FOOTER COPYRIGHT - END --}}
</footer>
