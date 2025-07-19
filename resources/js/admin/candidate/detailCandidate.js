// library
import axios from "axios";
import { Notyf } from "notyf";

export function fetchCandidateById(application_id) {
    axios
        .get(`/admin/candidates/${application_id}`)
        .then((response) => {
            const candidate = response.data;
            console.log("Candidate data:", candidate);

            const detailModal = document.getElementById("detailCandidateModal");
            detailModal.querySelector("#application_id").textContent =
                candidate.data.application_id;
            detailModal.querySelector("#candidate_name").textContent =
                candidate.data.user.freelancer_profile.name;
            detailModal.querySelector("#candidate_email").textContent =
                candidate.data.user.email;
            detailModal.querySelector("#candidate_birthdate").textContent =
                candidate.data.user.freelancer_profile.birthdate;
            detailModal.querySelector("#candidate_address").textContent =
                candidate.data.user.freelancer_profile.address;
            detailModal.querySelector("#candidate_phone").textContent =
                candidate.data.user.freelancer_profile.phone_number;
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

            // Get the CV file and generate a secure download link
            const fileCV = candidate.data.user.freelancer_profile.file_c_v;
            if (fileCV) {
                const cvUrl = `/admin/candidates/download/cv/${fileCV.file_id}`;
                const resumeAnchor =
                    detailModal.querySelector("#candidate_resume");
                resumeAnchor.textContent = fileCV.filename;
                resumeAnchor.href = cvUrl;
                resumeAnchor.target = "_blank";
            }

            // Get the SKKNI file and generate a secure download link
            const fileSKKNI =
                candidate.data.user.freelancer_profile.file_s_k_k_n_i;
            if (fileSKKNI) {
                const cvUrl = `/admin/candidates/download/cv/${fileSKKNI.file_id}`;
                const resumeAnchor =
                    detailModal.querySelector("#candidate_skkni");
                resumeAnchor.textContent = fileSKKNI.filename;
                resumeAnchor.href = cvUrl;
                resumeAnchor.target = "_blank";
            }

            // Get the SKKK file and generate a secure download link
            const fileSKKK =
                candidate.data.user.freelancer_profile.file_s_k_k_k;
            if (fileSKKK) {
                const cvUrl = `/admin/candidates/download/cv/${fileSKKK.file_id}`;
                const resumeAnchor =
                    detailModal.querySelector("#candidate_skkk");
                resumeAnchor.textContent = fileSKKK.filename;
                resumeAnchor.href = cvUrl;
                resumeAnchor.target = "_blank";
            }

            detailModal.querySelector("#candidate_about").textContent =
                candidate.data.user.freelancer_profile.about_me;

            const educationElement = detailModal.querySelector(
                "#candidate_education"
            );
            educationElement.innerHTML =
                candidate.data.user.freelancer_profile.educations
                    .map(
                        (edu) => `
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
                `Error fetching candidate id ${application_id}:`,
                error
            );
        });
}

document.addEventListener("DOMContentLoaded", () => {
    initializeModalDetails();
    const notyf = new Notyf();

    const acceptButton = document.getElementById("acceptCandidate");

    acceptButton.addEventListener("click", () => {
        const applicationId =
            document.getElementById("application_id").textContent;

        console.log("Accepting candidate with id:", applicationId);

        axios
            .post(`/admin/candidates/${applicationId}/accept`)
            .then((response) => {
                if (response.data.success) {
                    notyf.success("Kandidat berhasil diterima");
                    closeDetailCandidate();
                } else {
                    notyf.error("Kandidat gagal diterima");
                }
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the candidate status:",
                    error
                );
                notyf.error(
                    "Ups terjadi kesalahan saat mengupdate status kandidat"
                );
            });
    });

    const rejectButton = document.getElementById("rejectCandidate");

    rejectButton.addEventListener("click", () => {
        const applicationId =
            document.getElementById("application_id").textContent;

        console.log("Rejecting candidate with id:", applicationId);

        axios
            .post(`/admin/candidates/${applicationId}/reject`)
            .then((response) => {
                if (response.data.success) {
                    notyf.success("Kandidat berhasil ditolak");
                    closeDetailCandidate();
                } else {
                    notyf.error("Kandidat gagal ditolak");
                }
            })
            .catch((error) => {
                console.error(
                    "There was an error updating the candidate status:",
                    error
                );
                notyf.error(
                    "Ups terjadi kesalahan saat mengupdate status kandidat"
                );
            });
    });
});

/**
 * Open and close detail lowongan modal
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
    const openModalButtons = document.querySelectorAll(".open-detail-modal");
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
