import axios from "axios";
import { Notyf } from "notyf";

/**
 * menghapus freelancer function
 */
export function deleteFreelancer(freelancerId, fetchFreelancer) {
    const notyf = new Notyf();

    axios
        .delete(`/admin/freelancers/${freelancerId}`)
        .then((response) => {
            if (response.data.success) {
                notyf.success("Berhasil menghapus partner");
                fetchFreelancer();
            } else {
                notyf.error(
                    "Gagal menghapus partner: " + response.data.message
                );
            }
        })
        .catch((error) => {
            console.error("Error updating partner status:", error);
            notyf.error("Gagal menghapus partner, Coba Lagi");
        });
}

/**
 * menghapus freelancer modal
 */
document.addEventListener("click", function (event) {
    if (event.target.closest(".delete-freelancer-btn")) {
        const button = event.target.closest(".delete-freelancer-btn");
        const freelancerId = button.getAttribute("data-freelancer-id");

        const modal = document.getElementById("deleteFreelancerModal");
        modal.classList.remove("hidden");

        const confirmButton = document.getElementById("deleteFreelancer");
        confirmButton.setAttribute("data-freelancer-id", freelancerId);
    }
});

document.getElementById("cancelDelete").addEventListener("click", function () {
    const modal = document.getElementById("deleteFreelancerModal");
    modal.classList.add("hidden");
});
