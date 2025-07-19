/**
 * Open and close action menu
 */
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("popover-toggle")) {
        const button = e.target;
        const popover = button.nextElementSibling;
        popover.classList.toggle("hidden");
    }
});

document.addEventListener("click", (e) => {
    const popovers = document.querySelectorAll(".popover");
    popovers.forEach((popover) => {
        if (
            !popover.contains(e.target) &&
            !popover.previousElementSibling.contains(e.target)
        ) {
            popover.classList.add("hidden");
        }
    });
});

/**
 * Open and close tambah lowongan modal
 */
document.addEventListener("DOMContentLoaded", function () {
    const tambahLowonganButton = document.getElementById("tambahLowongan");
    const tambahLowonganModal = document.getElementById("tambahLowonganModal");
    const closeLowonganButtons = document.querySelectorAll("#closeLowongan");

    function openModal() {
        tambahLowonganModal.classList.remove("hidden");
    }

    function closeLowongan() {
        tambahLowonganModal.classList.add("hidden");
    }

    if (tambahLowonganButton) {
        tambahLowonganButton.addEventListener("click", openModal);
    } else {
        console.warn("Tambah Lowongan button not found.");
    }

    if (closeLowonganButtons.length > 0) {
        closeLowonganButtons.forEach((button) => {
            button.addEventListener("click", closeLowongan);
        });
    } else {
        console.warn("Close Lowongan buttons not found.");
    }
});
