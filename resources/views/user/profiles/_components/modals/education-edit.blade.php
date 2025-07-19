<div class="relative z-50 modal hidden" id="user-profile-education-edit" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div onclick="closeModal(this)" class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay">
        </div>
        <div class="p-4 mx-auto animate-translate sm:max-w-4xl">
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
                        <h3 class="mb-4 text-xl font-medium text-primary-500">Pendidikan</h3>
                        <button onclick="openModal(this)" data-tw-toggle="modal"
                            data-tw-target="#user-profile-education-form"
                            data-action="{{ route('users.profiles.educations.store') }}"
                            class="btn-primary-outlined">Tambah</button>
                        @foreach ($user->profile->educations->sortByDesc('graduate_year') as $edu)
                            <div class="my-4 flex w-full edit-item">
                                <div class="hidden edit-item-data" data-school_name="{{ $edu->school_name }}"
                                    data-major="{{ $edu->major }}" data-education_desc="{{ $edu->education_desc }}"
                                    data-graduate_year="{{ $edu->graduate_year }}"
                                    data-freelancer_educations_id="{{ $edu->freelancer_educations_id }}"
                                    data-action="{{ route('users.profiles.educations.update') }}">
                                </div>
                                @include('user.profiles._components.education-item', ['education' => $edu])
                                <div class="flex items-center justify-end gap-2 basis-4/12">
                                    <button class="btn-icon" onclick="openEditModal(this)" data-tw-toggle="modal"
                                        data-tw-target="#user-profile-education-form">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-pencil">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                    </button>
                                    <button class="btn-icon"
                                        onclick="openDeleteModal(this,'{{ route('users.profiles.educations.delete', ['id' => $edu->freelancer_educations_id]) }}')"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
