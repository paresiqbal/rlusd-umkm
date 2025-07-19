<div class="relative z-50 modal hidden " id="delete-confirmation-modal" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div onclick="closeModal(this)" class="fixed inset-0 transition-opacity bg-black bg-opacity-50 modal-overlay ">
        </div>
        <div class="p-4 mx-auto animate-translate sm:max-w-lg">
            <div class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl">
                <div class="bg-white">
                    <div class="p-5 flex flex-col items-center">
                        <div class="size-24 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 9v4" />
                                <path d="M12 16v.01" />
                            </svg>
                        </div>
                        <div class="font-semibold text-lg my-4 text-center">
                            Data terpilih akan dihapus. Lanjutkan?
                        </div>
                        <form action="" method="POST">
                            @method('DELETE')
                            @csrf
                            <div class="flex justify-center gap-4">
                                <button type="button" onclick="closeModal(this)" class="btn-secondary">Tidak</button>
                                <button type="submit" class="btn-primary">Ya</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
