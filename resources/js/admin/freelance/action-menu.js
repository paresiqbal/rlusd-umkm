export function actionMenu(cell) {
    return `
         <div class="relative">
            <button class='bg-white text-black px-4 py-2 rounded border border-gray-300 shadow-sm popover-toggle flex items-center text-sm'>
                Menu
                <img src="/assets/icons/sidebar/chevron-down.svg" alt="chevron-down" class="h-4 w-4 ml-2" />
            </button>
            <div class="popover hidden absolute bg-white border border-gray-300 rounded shadow-lg z-50">
               <ul class="text-sm">
                  <li>
                        <button 
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 detail-freelancer-btn open-detail-modal flex items-center gap-2" data-freelancer-id="${
                                cell.id
                            }">
                            <img src="/assets/icons/modal/detail.svg" alt="edit" class="h-4 w-4 mr-1" />
                            Detail
                        </button>
                    </li>
                    <li>
                        <button 
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 block-freelancer-btn open-block-modal flex items-center gap-2 ${
                                !cell.active
                                    ? "opacity-50 text-gray-500 cursor-not-allowed"
                                    : ""
                            }" 
                            data-freelancer-id="${cell.id}"
                            ${!cell.active ? "disabled" : ""}>
                            <img src="/assets/icons/modal/non-active-red.svg" alt="verifikasi" class="h-4 w-4 mr-1" />
                           Blokir
                        </button>
                    </li>
                  <li>
                        <button 
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 unblock-freelancer-btn open-unblock-modal flex items-center gap-2 ${
                                cell.active
                                    ? "opacity-50 text-gray-500 cursor-not-allowed"
                                    : ""
                            }" 
                            data-freelancer-id="${cell.id}"
                            ${cell.active ? "disabled" : ""}>
                            <img src="/assets/icons/modal/check.svg" alt="edit" class="h-4 w-4 mr-1" />
                            Batal Blokir
                        </button>
                    </li>
                   <li>
                        <button 
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 delete-freelancer-btn open-delete-modal flex items-center gap-2" data-freelancer-id="${
                                cell.id
                            }">
                            <img src="/assets/icons/modal/red-trash.svg" alt="hapus" class="h-4 w-4 mr-1" />
                            Hapus
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    `;
}
