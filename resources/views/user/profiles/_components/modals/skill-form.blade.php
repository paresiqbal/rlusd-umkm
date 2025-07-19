<div class="relative z-50 hidden modal" id="user-profile-skill-form" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div onclick="closeModal(this)" class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay">
        </div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <button onclick="closeModal(this)" type="button" class="absolute top-3 right-3 btn-icon"
                        data-tw-dismiss="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="p-5">
                        <h3 class="mb-4 text-xl font-medium text-gray-700">Lengkapi Data Kompetensi</h3>
                        <form class="space-y-4" action="{{ route('users.profiles.skills.store') }}" method="POST">
                            @csrf
                            @php
                                // Retrieve and decode the main_skill from the user's profile.
                                // Assuming it is stored as a JSON string.
                                $mainSkill = [];
                                if (isset(Auth::user()->profile->main_skill)) {
                                    $decoded = json_decode(Auth::user()->profile->main_skill, true);
                                    $mainSkill = is_array($decoded) ? $decoded : [];
                                }
                            @endphp

                            <div>
                                <div class="my-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox"
                                            class="form-checkbox text-primary-500 focus:ring-primary-500"
                                            name="main_skill[]" value="pendamping"
                                            {{ in_array('pendamping', $mainSkill) ? 'checked' : '' }}>
                                        <span class="ml-2">Pendamping</span>
                                    </label>

                                    <label class="inline-flex items-center ml-6">
                                        <input type="checkbox"
                                            class="form-checkbox text-primary-500 focus:ring-primary-500"
                                            name="main_skill[]" value="konsultan"
                                            {{ in_array('konsultan', $mainSkill) ? 'checked' : '' }}>
                                        <span class="ml-2">Konsultan</span>
                                    </label>
                                </div>
                                <label for="skill" class="form-label">Kompetensi Pendukung</label>
                                <div class="flex min-h-10">
                                    <select name="skills[]" id="skills" multiple class="form-select">
                                        {{-- Populate available skills. Here, we assume $user->profile->skills are the options currently selected --}}
                                        @foreach (Auth::user()->profile->skills as $skill)
                                            <option value="{{ $skill->skill_id }}" selected>
                                                {{ $skill->skill_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hidden h-48 form-extend"></div>
                            <div class="flex justify-end gap-4 mt-6">
                                <button type="button" class="btn-outlined" data-tw-dismiss="modal"
                                    onclick="closeModal(this)">Kembali</button>
                                <button type="submit" class="btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- Tom Select --}}
    <script src="{{ asset('assets/js/libs/tom-select/tom-select.complete.js') }}"></script>
    <script>
        const select = new TomSelect('[name="skills[]"]', {
            valueField: 'skill_id',
            labelField: 'skill_name',
            searchField: 'skill_name',
            loadThrottle: 1000,
            create: true,
            createFilter: function(input) {
                return !/^\d+$/.test(input)
            },
            load: function(query, callback) {
                console.log('Fetching.............')
                let url = '{{ url('/') }}/api/skill-list?query=' + encodeURIComponent(query)
                fetch(url)
                    .then(response => response.json())
                    .then(json => {
                        callback(json)
                        console.log(json)
                    })
                    .catch((e) => {
                        callback()
                    })
            },
            onInitialize: function() {
                document.querySelector('.ts-control').style.border = 'unset'
                document.querySelector('.ts-control').classList.add('bg-transparent')
                document.querySelector('.ts-control').classList.add('border-0')

                document.querySelector('.ts-dropdown').style.border = 'unset'
                document.querySelector('.ts-wrapper').style.zIndex = '99999'
            },
            onDropdownOpen: function(dropdown) {
                document.querySelector('.form-extend').classList.remove('hidden')
            },
            onDropdownClose: function(dropdown) {
                document.querySelector('.form-extend').classList.add('hidden')
            },
            onChange: function(value) {
                this.close()
            },
            render: {
                option_create: function(data, escape) {
                  return `<div class="create">Tambahkan <b>${escape(data.input)}...</b></div>`  
                },
                loading: function(data, escape) {
                    return `
        <div class="flex items-center justify-center p-4 overflow-hidden">
          <div class="spinner-border animate-spin inline-block w-8 h-8 border-[3px] border-l-transparent border-yellow-500 rounded-full">
            <span class="hidden">Loading...</span>
          </div>
        </div>`
                },
            },
            plugins: {
                remove_button: {
                    title: 'Hapus Item'
                }
            },
        })
    </script>
    {{-- Tom Select End --}}
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tom-select.min.css') }}">
@endpush
