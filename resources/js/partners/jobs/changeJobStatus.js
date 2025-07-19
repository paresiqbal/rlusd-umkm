import axios from "axios";
import { Notyf } from "notyf";

export function tutupLowongan(jobId, fetchJobs) {
    const notyf = new Notyf();

    axios
        .put(`/partner/jobs/update-status/${jobId}`, { status: "closed" })
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil menutup Lowongan");
                fetchJobs();
            } else {
                notyf.error("Gagal menutup Lowongan: " + response.data.message);
            }
        })
        .catch((error) => {
            console.error("Error updating job status:", error);
            notyf.error("Gagal menutup Lowongan, Coba Lagi");
        });
}

/**
 * Menutup status lowongan
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".tutup-lowongan-btn")) {
        const button = event.target.closest(".tutup-lowongan-btn");
        const jobId = button.getAttribute("data-job-id");

        const modal = document.getElementById("tutupLowonganModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("changeTutup");
        confirmButton.setAttribute("data-job-id", jobId);
    }
});

/**
 * Change job status tutup lowongan modal
 */
document.getElementById("cancelTutup").addEventListener("click", function () {
    const modal = document.getElementById("tutupLowonganModal");
    modal.classList.add("hidden");
});
