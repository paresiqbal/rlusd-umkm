import { Notyf } from "notyf";

document.addEventListener("DOMContentLoaded", function () {
    const applyJobBtns = document.querySelectorAll(".apply-job-btn");
    const applyJobModal = document.getElementById("applyJobModal");
    const closeApplyBtn = document.getElementById("cancel-apply");
    const applyJobForm = document.getElementById("applyJobForm");
    const notyf = new Notyf();

    function openModal(event) {
        const jobId = event.currentTarget.getAttribute("data-job-id");
        applyJobForm.action = `/jobs/${jobId}/apply`;
        applyJobModal.classList.remove("hidden");
    }

    function closeModal() {
        applyJobModal.classList.add("hidden");
    }

    // ✅ Add listeners to all "Apply" buttons
    applyJobBtns.forEach((btn) => {
        btn.addEventListener("click", openModal);
    });

    if (closeApplyBtn) {
        closeApplyBtn.addEventListener("click", closeModal);
    } else {
        console.error("Close Apply Job button not found!");
    }

    // Uncomment this if using a session message system
    // const successMessage = "{{ session('success') }}";
    // if (successMessage) {
    //     notyf.success("Lamaran berhasil dikirim!");
    // }
});
