import axios from "axios";
import { Notyf } from "notyf";

export function deleteJob(jobId, onSuccess) {
    const notyf = new Notyf();

    axios
        .delete(`/partner/jobs/${jobId}`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Lowongan Berhasil Dihapus");
                if (typeof onSuccess === "function") {
                    onSuccess();
                }
            } else {
                notyf.error("Gagal Menghapus Lowongan");
            }
        })
        .catch((error) => {
            console.error("Error deleting job:", error);
            notyf.error("Gagal Menghapus Lowongan");
        });
}

/**
 * Delete lowongan modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".delete-job-btn")) {
        const button = event.target.closest(".delete-job-btn");
        const jobId = button.getAttribute("data-job-id");

        // Show the modal
        const modal = document.getElementById("deleteConfirmationModal");
        modal.classList.remove("hidden");

        // Attach the job ID to the confirm button
        const confirmButton = document.getElementById("confirmDeleteButton");
        confirmButton.setAttribute("data-job-id", jobId);
    }
});

document
    .getElementById("cancelDeleteButton")
    .addEventListener("click", function () {
        const modal = document.getElementById("deleteConfirmationModal");
        modal.classList.add("hidden");
    });
