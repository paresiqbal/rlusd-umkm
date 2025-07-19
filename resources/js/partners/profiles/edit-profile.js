document.addEventListener("DOMContentLoaded", () => {
    const editProfileModal = document.getElementById("edit-profile-modal");
    const editProfileButton = document.getElementById("edit-profile-btn");
    const closeProfileButton = document.getElementById("close-profile-modal");
    const saveProfileButton = document.getElementById("save-profile-btn");

    // Function to open the modal
    function openProfileModal() {
        if (editProfileModal) {
            editProfileModal.classList.remove("hidden");
        }
    }

    // Function to close the modal
    function closeProfileModal() {
        if (editProfileModal) {
            editProfileModal.classList.add("hidden");
        }
    }

    // Function to save the profile data
    function saveProfile() {
        const name = document.getElementById("name").value.trim();
        const birthdate = document.getElementById("birthdate").value.trim();
        const gender = document.querySelector("select[name='gender']").value;
        const address = document
            .querySelector("textarea[name='address']")
            .value.trim();
        const province = document.getElementById("select_province").value;
        const city = document.getElementById("select_city").value;
        const postalCode = document.getElementById("postal_code").value.trim();
        const phoneNumber = document.getElementById("phone").value.trim();

        if (
            !name ||
            !birthdate ||
            !gender ||
            !address ||
            !province ||
            !city ||
            !postalCode ||
            !phoneNumber
        ) {
            alert("Please fill in all fields.");
            return;
        }

        // reset the form and close the modal
        document.getElementById("name").value = "";
        document.getElementById("birthdate").value = "";
        document.querySelector("select[name='gender']").value = "";
        document.querySelector("textarea[name='address']").value = "";
        document.getElementById("select_province").value = "";
        document.getElementById("select_city").value = "";
        document.getElementById("postal_code").value = "";
        document.getElementById("phone").value = "";
        closeProfileModal();
    }

    // Event listeners
    if (editProfileButton) {
        editProfileButton.addEventListener("click", openProfileModal);
    }

    if (closeProfileButton) {
        closeProfileButton.addEventListener("click", closeProfileModal);
    }

    // Save profile when the save button is clicked
    if (saveProfileButton) {
        saveProfileButton.addEventListener("click", saveProfile);
    }
});
