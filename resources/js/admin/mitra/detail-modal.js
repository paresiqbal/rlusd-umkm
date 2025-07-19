// library
import axios from "axios";
import { Notyf } from "notyf";

export function fetchMitraById(partnerId) {
    axios
        .get(`/admin/partners/${partnerId}`)
        .then((response) => {
            const partner = response.data;
            console.log(partner);

            const detailModal = document.getElementById("detailMitraModal");
            if (detailModal) {
                detailModal.querySelector("#mitra_id").textContent =
                    partner.user_id;
                // Display photoprofile if available.
                const photoProfile = partner.partner_profile.photo_profile;
                const profilePictureEl =
                    document.getElementById("profilePicture");
                if (photoProfile && photoProfile.public_url) {
                    profilePictureEl.src = photoProfile.public_url;
                } else {
                    profilePictureEl.src = "/assets/img/default-avatar.jpg";
                }

                detailModal.querySelector("#company_name").textContent =
                    partner.partner_profile.partner_name;
                detailModal.querySelector("#about_company").textContent =
                    partner.partner_profile.about_company;
                detailModal.querySelector("#company_email").textContent =
                    partner.email;
                detailModal.querySelector("#phone_number").textContent =
                    partner.partner_profile.phone_number;
                detailModal.querySelector("#company_address").textContent =
                    partner.partner_profile.address;
                detailModal.classList.remove("hidden");

                // add narahubung
                detailModal.querySelector("#pic_name").textContent =
                    partner.partner_profile.pic_name;
                detailModal.querySelector("#pic_email").textContent =
                    partner.partner_profile.pic_email;
                detailModal.querySelector("#pic_phone_number").textContent =
                    partner.partner_profile.pic_phone_number;
                detailModal.querySelector("#pic_position").textContent =
                    partner.partner_profile.pic_position;
            } else {
                console.error("Detail modal element not found.");
            }
        })
        .catch((error) => {
            console.error(`Error fetching job with ID ${partnerId}:`, error);
        });
}

/**
 * Open and close detail lowongan modal
 */
function openDetailMitra() {
    const modal = document.getElementById("detailMitraModal");
    if (modal) {
        modal.classList.remove("hidden");
    } else {
        console.error("Detail Lowongan Modal not found!");
    }
}

function closeDetailMitra() {
    const modal = document.getElementById("detailMitraModal");
    if (modal) {
        modal.classList.add("hidden");
    } else {
        console.error("Detail Lowongan Modal not found!");
    }
}

function initializeModalDetails() {
    const openModalButtons = document.querySelectorAll(".open-detail-modal");
    document.addEventListener("click", (event) => {
        if (event.target.closest(".open-detail-modal")) {
            openDetailMitra();
        }
    });

    const closeModalButtons = document.querySelectorAll("#closeDetailMitra");
    closeModalButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            closeDetailMitra();
        });
    });

    window.addEventListener("click", (event) => {
        const modal = document.getElementById("detailLowonganModal");
        if (event.target === modal) {
            closeDetailMitra();
        }
    });
}

document.addEventListener("DOMContentLoaded", initializeModalDetails);
