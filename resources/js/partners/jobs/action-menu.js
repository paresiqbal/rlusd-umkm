export function actionMenu({ id, status }) {
    const isClosed = status.toLowerCase() === "closed";
    return `
         <div class="relative">
            <button class='px-4 py-2 rounded-lg border popover-toggle flex items-center text-sm'>
                Menu
                <img src="/assets/icons/sidebar/chevron-down.svg" alt="chevron-down" class="h-4 w-4 ml-2" />
            </button>
            <div class="popover hidden absolute bg-white border border-gray-300 rounded shadow-lg z-50">
                <ul class="text-sm">
                  <li>
                        <button 
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 detail-job-btn open-detail-modal flex items-center gap-2" 
                            data-job-id="${id}">
                            <img src="/assets/icons/modal/detail.svg" alt="detail" class="h-4 w-4 mr-1" />
                            Detail
                        </button>
                    </li>
                  <li>
                        <button 
                            class="w-full text-left px-4 py-2 ${
                                isClosed
                                    ? "bg-gray-50 cursor-not-allowed"
                                    : "hover:bg-gray-100"
                            } edit-job-btn open-edit-modal flex items-center gap-2" 
                            data-job-id="${id}" ${
        isClosed ? 'disabled title="Job closed, cannot edit"' : ""
    }>
                            <img src="/assets/icons/modal/edit.svg" alt="edit" class="h-4 w-4 mr-1" />
                            Edit
                        </button>
                    </li>
                    <li>
                        <button 
                            class="w-full text-left px-4 py-2 ${
                                isClosed
                                    ? "bg-gray-50 cursor-not-allowed"
                                    : "hover:bg-gray-100"
                            } flex items-center gap-2 tutup-lowongan-btn" 
                            data-job-id="${id}" data-status="closed" ${
        isClosed ? 'disabled title="Job closed, cannot close"' : ""
    }>
                            <img src="/assets/icons/modal/check.svg" alt="verifikasi" class="h-4 w-4 mr-1" />
                            Tutup Lowongan
                        </button>
                    </li>
                   <li>
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 delete-job-btn flex items-center gap-2" data-job-id="${id}">
                            <img src="/assets/icons/modal/red-trash.svg" alt="hapus" class="h-4 w-4 mr-1" />
                            Hapus
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    `;
}
