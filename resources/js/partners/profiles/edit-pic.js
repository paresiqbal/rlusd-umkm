document.addEventListener("DOMContentLoaded", () => {
    const aboutModal = document.getElementById("user-profile-pic");
    const editModal = document.getElementById("edit-about-pic");
    const closeModal = aboutModal.querySelectorAll("[data-tw-dismiss='modal']");

    function openAboutModal() {
        aboutModal.classList.remove("hidden");
    }

    function closeAboutModal() {
        aboutModal.classList.add("hidden");
    }

    // Event listeners
    editModal.addEventListener("click", openAboutModal);
    closeModal.forEach((button) => {
        button.addEventListener("click", closeAboutModal);
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", (e) => {
        if (e.target === aboutModal) {
            closeAboutModal();
        }
    });
});
