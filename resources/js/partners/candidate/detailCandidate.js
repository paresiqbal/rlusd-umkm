// library
import axios from "axios";
import { Notyf } from "notyf";

export function fetchCandidateById(applicationId) {
    axios
        .get(`/partner/candidates/${applicationId}`)
        .then((response) => {
            const candidate = response.data;
            const birthdateStr =
                candidate.data.user.freelancer_profile.birthdate;
            const birthdate = new Date(birthdateStr);
            const today = new Date();

            // Calculate age
            let age = today.getFullYear() - birthdate.getFullYear();
            const m = today.getMonth() - birthdate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
                age--;
            }
            console.log("Fetch lamaran id ke:", candidate);

            const detailModal = document.getElementById("detailCandidateModal");
            detailModal.querySelector("#application_id").textContent =
                candidate.data.application_id;
            detailModal.querySelector("#candidate_name").textContent =
                candidate.data.user.freelancer_profile.name;
            detailModal.querySelector("#candidate_birthdate").textContent =
                candidate.data.user.freelancer_profile.birthdate;
            detailModal.querySelector("#candidate_age").textContent = age;
            // detailModal.querySelector("#candidate_address").textContent =
            //     candidate.data.user.freelancer_profile.address;
            detailModal.querySelector("#candidate_about").textContent =
                candidate.data.user.freelancer_profile.about_me;
            detailModal.querySelector("#candidate_status").textContent =
                candidate.data.status;

            // Display photoprofile if available.
            const photoProfile =
                candidate.data.user.freelancer_profile.photo_profile;
            const profilePictureEl = document.getElementById("profilePicture");
            if (photoProfile && photoProfile.public_url) {
                profilePictureEl.src = photoProfile.public_url;
            } else {
                profilePictureEl.src = "/assets/img/default-avatar.jpg";
            }

            const educationElement = detailModal.querySelector(
                "#candidate_education"
            );
            educationElement.innerHTML =
                candidate.data.user.freelancer_profile.educations
                    .map(
                        (edu) =>
                            `
                        <div class="mb-2">
                            <strong>${edu.major}</strong>
                            <br>
                            <span class="font-light">${edu.school_name}</span>
                            <br>
                            ${edu.graduate_year}
                            <br>
                            <span>${edu.education_desc}</span>
                        </div>
                        `
                    )
                    .join("");

            const experienceElement = detailModal.querySelector(
                "#candidate_experience"
            );
            experienceElement.innerHTML =
                candidate.data.user.freelancer_profile.experiences
                    .map(
                        (exp) => `
                        <div class="mb-2">
                          <strong>${exp.job_title}</strong>
                          <br>
                          ${exp.company_name}
                          <br>
                          ${exp.start_at} - ${exp.end_at}
                          <br>
                          ${exp.job_desc}
                        </div>
                      `
                    )
                    .join("");

            const skillsElement =
                detailModal.querySelector("#candidate_skills");
            skillsElement.innerHTML =
                candidate.data.user.freelancer_profile.skills
                    .map(
                        (skill) => `
                        <span class="px-2 py-1 rounded-md border border-gray-300 mx-1">
                          ${skill.skill_name}
                        </span>
                      `
                    )
                    .join("");
        })
        .catch((error) => {
            console.error(
                `Error fetching lamaran id ke ${applicationId}:`,
                error
            );
        });
}

document.addEventListener("DOMContentLoaded", () => {
    initializeModalDetails();

    const acceptButton = document.getElementById("acceptCandidate");
    const rejectButton = document.getElementById("rejectCandidate");
    const completedButton = document.getElementById("completedCandidate");
    const notyf = new Notyf();

    // accept candidate
    acceptButton.addEventListener("click", () => {
        const applicationId =
            document.getElementById("application_id").textContent;
        axios
            .post(`/partner/candidates/${applicationId}/accept`)
            .then((response) => {
                if (response.data.success) {
                    closeDetailCandidate();
                    notyf.success("Kandidat berhasil diterima");
                } else {
                    notyf.error("Gagal menolak kandidat");
                }
                window.location.reload();
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the candidate status:",
                    error
                );
            });
    });

    // reject candidate
    rejectButton.addEventListener("click", () => {
        const applicationId =
            document.getElementById("application_id").textContent;
        axios
            .post(`/partner/candidates/${applicationId}/reject`)
            .then((response) => {
                if (response.data.success) {
                    notyf.error("Kandidat berhasil ditolak");
                    closeDetailCandidate();
                    window.location.reload();
                } else {
                    notyf.error("Gagal menolak kandidat");
                }
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the candidate status:",
                    error
                );
            });
    });

    // complete candidate
    completedButton.addEventListener("click", () => {
        const applicationId =
            document.getElementById("application_id").textContent;
        axios
            .post(`/partner/candidates/${applicationId}/complete`)
            .then((response) => {
                if (response.data.success) {
                    closeDetailCandidate();
                    notyf.success("Pekerjaan Kandidat selesai");
                } else {
                    notyf.error("Gagal Menyelesaikan Pekerjaan Kandidat");
                }
                window.location.reload();
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the candidate status:",
                    error
                );
            });
    });
});

/**
 * Open and close detail candidate modal
 */
function openDetailCandidate() {
    const modal = document.getElementById("detailCandidateModal");
    if (modal) {
        modal.classList.remove("hidden");
    } else {
        console.error("Detail Lowongan Modal not found!");
    }
}

function closeDetailCandidate() {
    const modal = document.getElementById("detailCandidateModal");
    if (modal) {
        modal.classList.add("hidden");
    } else {
        console.error("Detail Lowongan Modal not found!");
    }
}

function initializeModalDetails() {
    document.addEventListener("click", (event) => {
        if (event.target.closest(".open-detail-modal")) {
            openDetailCandidate();
        }
    });

    const closeModalButtons = document.querySelectorAll("#closeCandidateModal");
    closeModalButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            closeDetailCandidate();
        });
    });

    window.addEventListener("click", (event) => {
        const modal = document.getElementById("detailCandidateModal");
        if (event.target === modal) {
            closeDetailCandidate();
        }
    });
}

document.addEventListener("DOMContentLoaded", initializeModalDetails);
