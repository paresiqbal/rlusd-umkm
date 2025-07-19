import axios from "axios";
import { Notyf } from "notyf";

/**
 * memblokir mitra fucntion
 */
export function blockMitra(partnerId, fetchPartners) {
    const notyf = new Notyf();

    axios
        .post(`/admin/partners/${partnerId}/deactivate`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil memblokir partner");
                fetchPartners();
            } else {
                notyf.error(
                    "Gagal memblokir partner: " + response.data.message
                );
            }
        })
        .catch((error) => {
            console.error("Error updating partner status:", error);
            notyf.error("Gagal memblokir partner, Coba Lagi");
        });
}

/**
 * memblokir mitra modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".block-mitra-btn")) {
        const button = event.target.closest(".block-mitra-btn");
        const partnerId = button.getAttribute("data-mitra-id");

        const modal = document.getElementById("blockMitraModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("blockMitra");
        confirmButton.setAttribute("data-mitra-id", partnerId);
    }
});

document.getElementById("cancelBlock").addEventListener("click", function () {
    const modal = document.getElementById("blockMitraModal");
    modal.classList.add("hidden");
});

/**
 * membbuka lokir mitra fucntion
 */
export function unBlockMitra(partnerId, fetchPartners) {
    const notyf = new Notyf();

    axios
        .post(`/admin/partners/${partnerId}/activate`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil membuka blokir partner");
                fetchPartners();
            } else {
                notyf.error(
                    "Gagal membuka blokir partner: " + response.data.message
                );
            }
        })
        .catch((error) => {
            console.error("Error updating partner status:", error);
            notyf.error("Gagal membbuka lokir partner, Coba Lagi");
        });
}

/**
 * membuka blokir mitra modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".unblock-mitra-btn")) {
        const button = event.target.closest(".unblock-mitra-btn");
        const partnerId = button.getAttribute("data-mitra-id");

        const modal = document.getElementById("unBlockMitraModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("unBlockMitra");
        confirmButton.setAttribute("data-mitra-id", partnerId);
    }
});

document.getElementById("cancelUnBlock").addEventListener("click", function () {
    const modal = document.getElementById("unBlockMitraModal");
    modal.classList.add("hidden");
});
