// library
import axios from "axios";
import { Notyf } from "notyf";

// utils
import { formatSalary } from "../../utils/formatter";

export function fetchJobById(jobId) {
    axios
        .get(`/admin/vacancies/${jobId}`)
        .then((response) => {
            const job = response.data;
            console.log("Fetched Job by ID:", job);

            const detailModal = document.getElementById("detailLowonganModal");
            if (detailModal) {
                detailModal.querySelector("#detail_post_job_id").textContent =
                    job.data.post_job_id;
                detailModal.querySelector("#detail_role").textContent =
                    job.data.role;
                detailModal.querySelector("#detail_job_desc").textContent =
                    job.data.job_desc;
                detailModal.querySelector("#detail_number_sdm").textContent =
                    job.data.number_sdm;
                detailModal.querySelector(
                    "#detail_education_name"
                ).textContent = job.data.education.education_name;
                detailModal.querySelector("#detail_genders").textContent =
                    job.data.genders;
                detailModal.querySelector("#detail_job_type_name").textContent =
                    job.data.job_type.job_type_name;
                detailModal.querySelector("#detail_service_types").textContent =
                    job.data.service_types
                        .map(({ service_type_name }) => service_type_name)
                        .join(", ");
                detailModal.querySelector("#detail_province").textContent =
                    job.data.province.province_name;
                detailModal.querySelector("#detail_district").textContent =
                    job.data.district.district_name;
                detailModal.querySelector("#detail_subdistrict").textContent =
                    job.data.subdistrict.subdistrict_name;
                detailModal.querySelector("#detail_address").textContent =
                    job.data.address;
                detailModal.querySelector(
                    "#detail_employment_type_name"
                ).textContent = job.data.employment_type.employment_type_name;
                detailModal.querySelector(
                    "#detail_qualifications"
                ).textContent = job.data.qualifications;
                detailModal.querySelector("#detail_skills").textContent =
                    job.data.skills.map((skill) => skill.skill_name);
                detailModal.querySelector("#detail_min_salary").textContent =
                    formatSalary(job.data.min_salary);
                detailModal.querySelector("#detail_max_salary").textContent =
                    formatSalary(job.data.max_salary);
                detailModal.querySelector("#detail_status").textContent =
                    job.data.status;

                detailModal.classList.remove("hidden");
            } else {
                console.error("Detail modal element not found.");
            }
        })
        .catch((error) => {
            console.error(`Error fetching job with ID ${jobId}:`, error);
        });
}

/**
 * accept and reject jobs by mitra
 */
document.addEventListener("DOMContentLoaded", () => {
    initializeModalDetails();

    const acceptButton = document.getElementById("acceptJobs");
    const notyf = new Notyf();

    acceptButton.addEventListener("click", () => {
        const jobId = document.getElementById("detail_post_job_id").textContent;

        console.log("Accepting jobs with id:", jobId);

        axios
            .post(`/admin/vacancies/${jobId}/accept`)
            .then((response) => {
                if (response.data.success) {
                    notyf.success("Kebutuhan jasa berhasil diterima");
                    closeDetailLowonganModal();
                    document.dispatchEvent(new CustomEvent("jobsUpdated"));
                } else {
                    notyf.success("Kebutuhan jasa berhasil ditolak");
                }

                // Set the form action to include the job ID
                document.getElementById(
                    "detail_post_job_id"
                ).action = `/admin/vacancies/${jobId}/accept`;
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the jobs status:",
                    error
                );
                notyf.error("Ups ada yang error");
            });
    });

    const rejectButton = document.getElementById("rejectJobs");

    rejectButton.addEventListener("click", () => {
        const jobId = document.getElementById("detail_post_job_id").textContent;

        console.log("Rejecting jobs with id:", jobId);

        axios
            .post(`/admin/vacancies/${jobId}/reject`)
            .then((response) => {
                if (response.data.success) {
                    notyf.success("Kebutuhan jasa berhasil ditolak");
                    closeDetailLowonganModal();
                    document.dispatchEvent(new CustomEvent("jobsUpdated"));
                } else {
                    notyf.error("Gagal menolak kebutuhan jasa");
                }

                document.getElementById(
                    "detail_post_job_id"
                ).action = `/admin/vacancies/${jobId}/reject`;
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the jobs status:",
                    error
                );
                notyf.error("Ups ada yang error");
            });
    });
});

/**
 * Open and close detail lowongan modal
 */
function openDetailLowonganModal() {
    const modal = document.getElementById("detailLowonganModal");
    if (modal) {
        modal.classList.remove("hidden");
    } else {
        console.error("Detail Lowongan Modal not found!");
    }
}

function closeDetailLowonganModal() {
    const modal = document.getElementById("detailLowonganModal");
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
            openDetailLowonganModal();
        }
    });

    const closeModalButtons = document.querySelectorAll("#closeDetailLowongan");
    closeModalButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            closeDetailLowonganModal();
        });
    });

    window.addEventListener("click", (event) => {
        const modal = document.getElementById("detailLowonganModal");
        if (event.target === modal) {
            closeDetailLowonganModal();
        }
    });
}

document.addEventListener("DOMContentLoaded", initializeModalDetails);
