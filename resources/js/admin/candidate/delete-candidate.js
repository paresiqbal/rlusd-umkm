import axios from "axios";
import { Notyf } from "notyf";

export function deleteCandidate(application_id, onSuccess) {
    const notyf = new Notyf();

    axios
        .delete(`/admin/candidates/${application_id}`)
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

document.addEventListener("click", function (event) {
    if (event.target.closest(".delete-job-btn")) {
        const button = event.target.closest(".delete-job-btn");
        const applicationId = button.getAttribute("data-candidate-id");

        // Show the modal
        const modal = document.getElementById("deleteConfirmationModal");
        modal.classList.remove("hidden");

        // Attach the candidate ID to the confirm button
        const confirmButton = document.getElementById("confirmDeleteButton");
        confirmButton.setAttribute("data-candidate-id", applicationId);
    }
});

document
    .getElementById("cancelDeleteButton")
    .addEventListener("click", function () {
        const modal = document.getElementById("deleteConfirmationModal");
        modal.classList.add("hidden");
    });

document
    .getElementById("confirmDeleteButton")
    .addEventListener("click", function () {
        const applicationId = this.getAttribute("data-candidate-id");
        deleteCandidate(applicationId, function () {
            const modal = document.getElementById("deleteConfirmationModal");
            modal.classList.add("hidden");

            // Optionally, remove the candidate row from the DOM
            const candidateRow = document
                .querySelector(`[data-candidate-id="${applicationId}"]`)
                .closest("tr");
            if (candidateRow) {
                candidateRow.remove();
            }
        });
    });
