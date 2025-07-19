import axios from "axios";
import { Notyf } from "notyf";

/**
 * memblokir freelancer fucntion
 */
export function blockFreelancer(freelancerId, fetchFreelancer) {
    const notyf = new Notyf();

    axios
        .post(`/admin/freelancers/${freelancerId}/deactivate`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil memblokir partner");
                fetchFreelancer();
            } else {
                notyf.error("Gagal memblokir partner");
            }
        })
        .catch((error) => {
            console.error("Error updating partner status:", error);
            notyf.error("Gagal memblokir partner, Coba Lagi");
        });
}

/**
 * memblokir freelancer modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".block-freelancer-btn")) {
        const button = event.target.closest(".block-freelancer-btn");
        const freelancerId = button.getAttribute("data-freelancer-id");

        const modal = document.getElementById("blockFreelancerModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("blockFreelancer");
        confirmButton.setAttribute("data-freelancer-id", freelancerId);
    }
});

document.getElementById("cancelBlock").addEventListener("click", function () {
    const modal = document.getElementById("blockFreelancerModal");
    modal.classList.add("hidden");
});

/**
 * membbuka lokir freelancer fucntion
 */
export function unBlockFreelancer(freelancerId, fetchFreelancer) {
    const notyf = new Notyf();

    axios
        .post(`/admin/freelancers/${freelancerId}/activate`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil membuka blokir partner");
                fetchFreelancer();
            } else {
                notyf.error("Gagal membuka blokir partner");
            }
        })
        .catch((error) => {
            console.error("Error updating partner status:", error);
            notyf.error("Gagal membbuka lokir partner, Coba Lagi");
        });
}

/**
 * membuka blokir freelancer modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".unblock-freelancer-btn")) {
        const button = event.target.closest(".unblock-freelancer-btn");
        const freelancerId = button.getAttribute("data-freelancer-id");

        const modal = document.getElementById("unBlockFreelancerModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("unBlockFreelancer");
        confirmButton.setAttribute("data-freelancer-id", freelancerId);
    }
});

document.getElementById("cancelUnBlock").addEventListener("click", function () {
    const modal = document.getElementById("unBlockFreelancerModal");
    modal.classList.add("hidden");
});
