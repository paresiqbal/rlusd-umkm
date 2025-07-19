import axios from "axios";
import { Notyf } from "notyf";

export function deleteJob(applicationId, onSuccess) {
    const notyf = new Notyf();

    axios
        .delete(`/partner/candidates/${applicationId}`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Konsultan Berhasil Dihapus");
                if (typeof onSuccess === "function") {
                    onSuccess();
                }
            } else {
                notyf.error("Gagal Menghapus Konsultan");
            }
        })
        .catch((error) => {
            console.error("Error deleting consultant:", error);
            notyf.error("Gagal Menghapus Konsultan");
        });
}

/**
 * Delete lowongan
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".delete-job-btn")) {
        const button = event.target.closest(".delete-job-btn");
        const applicationId = button.getAttribute("data-job-id");

        // Show the modal
        const modal = document.getElementById("deleteConfirmationModal");
        modal.classList.remove("hidden");

        // Attach the job ID to the confirm button
        const confirmButton = document.getElementById("confirmDeleteButton");
        confirmButton.setAttribute("data-job-id", applicationId);
    }
});

document
    .getElementById("cancelDeleteButton")
    .addEventListener("click", function () {
        const modal = document.getElementById("deleteConfirmationModal");
        modal.classList.add("hidden");
    });
