import axios from "axios";
import { Notyf } from "notyf";

/**
 * menghapus mitra function
 */
export function deleteMitra(partnerId, fetchPartners) {
    const notyf = new Notyf();

    axios
        .delete(`/admin/partners/${partnerId}`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil menghapus partner");
                fetchPartners();
            } else {
                notyf.error(
                    "Gagal menghapus partner: " + response.data.message
                );
            }
        })
        .catch((error) => {
            console.error("Error updating partner status:", error);
            notyf.error("Gagal menghapus partner, Coba Lagi");
        });
}

/**
 * menghapus mitra modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".delete-mitra-btn")) {
        const button = event.target.closest(".delete-mitra-btn");
        const partnerId = button.getAttribute("data-mitra-id");

        const modal = document.getElementById("deleteMitraModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("deleteMitra");
        confirmButton.setAttribute("data-mitra-id", partnerId);
    }
});

document.getElementById("cancelDelete").addEventListener("click", function () {
    const modal = document.getElementById("deleteMitraModal");
    modal.classList.add("hidden");
});
