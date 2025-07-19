export function actionMenu(partner) {
    return `
         <div class="relative">
            <button class="px-4 py-2 rounded-lg border popover-toggle flex items-center text-sm">
                Menu
                <img src="/assets/icons/sidebar/chevron-down.svg" alt="chevron-down" class="h-4 w-4 ml-2" />
            </button>
            <div class="popover hidden absolute bg-white border border-gray-300 rounded shadow-lg z-50">
                <ul class="text-sm">
                  <li>
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 detail-mitra-btn open-detail-modal flex items-center gap-2" data-mitra-id="${
                            partner.id
                        }">
                            <img src="/assets/icons/modal/detail.svg" alt="edit" class="h-4 w-4 mr-1" />
                            Detail
                        </button>
                    </li>
                    <li>
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 block-mitra-btn open-block-modal flex items-center gap-2 ${
                            !partner.isActive
                                ? "text-gray-400 cursor-not-allowed"
                                : ""
                        }" data-mitra-id="${partner.id}" ${
        partner.isActive ? "" : "disabled"
    }>
                            <img src="/assets/icons/modal/non-active-red.svg" alt="verifikasi" class="h-4 w-4 mr-1" />
                           Blokir
                        </button>
                    </li>
                    <li>
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 unblock-mitra-btn open-unblock-modal flex items-center gap-2 ${
                            partner.isActive
                                ? "text-gray-400 cursor-not-allowed"
                                : ""
                        }" data-mitra-id="${partner.id}" ${
        partner.isActive ? "disabled" : ""
    }>
                            <img src="/assets/icons/modal/check.svg" alt="edit" class="h-4 w-4 mr-1" />
                            Batal Blokir
                        </button>
                    </li>
                   <li>
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 delete-mitra-btn open-delete-modal flex items-center gap-2" data-mitra-id="${
                            partner.id
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
