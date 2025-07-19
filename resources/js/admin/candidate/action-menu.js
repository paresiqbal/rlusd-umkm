export function actionMenu(cell) {
    return `
         <div class="relative">
            <button class='bg-white text-black px-4 py-2 rounded border border-gray-300 shadow-sm popover-toggle flex items-center text-sm'>
                Menu
                <img src="/assets/icons/sidebar/chevron-down.svg" alt="chevron-down" class="h-4 w-4 ml-2" />
            </button>
            <div class="popover hidden absolute bg-white border border-gray-300 rounded shadow-lg z-50">
                <ul class="text-sm text-gray-800">
                    <li>
                        <button 
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 detail-candidate-btn open-detail-modal flex items-center gap-2" data-candidate-id="${cell}">
                            <img src="/assets/icons/modal/detail.svg" alt="edit" class="h-4 w-4 mr-1" />
                            Detail
                        </button>
                    </li>
                    <li>
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100 detail-button flex items-center gap-2 delete-job-btn open-delete-modal" data-candidate-id="${cell}">
                            <img src="/assets/icons/modal/trash.svg" alt="trash" class="h-4 w-4 mr-1" />
                            Hapus
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    `;
}
