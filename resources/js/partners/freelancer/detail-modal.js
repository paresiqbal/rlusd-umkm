// library
import axios from "axios";
import { Notyf } from "notyf";

export function fetchfreelancerById(freelanceId) {
    axios
        .get(`/admin/freelancers/${freelanceId}`)
        .then((response) => {
            const freelancer = response.data;
            console.log("freelancer", freelancer);

            const detailModal = document.getElementById(
                "detailFreelancerModal"
            );
            if (detailModal) {
                detailModal.querySelector("#freelancer_id").textContent =
                    freelancer.data.user_id;
                detailModal.querySelector("#freelance_name").textContent =
                    freelancer.data.freelancer_profile.name;
                detailModal.querySelector("#freelance_email").textContent =
                    freelancer.data.email;
                detailModal.querySelector("#freelance_birthdate").textContent =
                    freelancer.data.freelancer_profile.birthdate;
                detailModal.querySelector("#freelance_address").textContent =
                    freelancer.data.freelancer_profile.address;
                detailModal.querySelector(
                    "#freelance_phone_number"
                ).textContent = freelancer.data.freelancer_profile.phone_number;
                detailModal.querySelector("#freelance_resume").textContent =
                    freelancer.data.freelancer_profile.file_c_v.filename;
                detailModal.querySelector("#freelance_skkni").textContent =
                    freelancer.data.freelancer_profile.file_s_k_k_n_i.filename;
                detailModal.querySelector("#freelance_skkk").textContent =
                    freelancer.data.freelancer_profile.file_s_k_k_k.filename;
                detailModal.querySelector("#freelance_about").textContent =
                    freelancer.data.freelancer_profile.about_me;

                const educationElement = detailModal.querySelector(
                    "#freelance_education"
                );

                educationElement.innerHTML =
                    freelancer.data.freelancer_profile.educations
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
                    "#freelance_experience"
                );
                experienceElement.innerHTML =
                    freelancer.data.freelancer_profile.experiences
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
                const achievementElemen = detailModal.querySelector(
                    "#freelance_achievement"
                );
                achievementElemen.innerHTML =
                    freelancer.data.freelancer_profile.achievements
                        .map(
                            (ach) => `
                                    <div class="mb-2">
                                        <strong>${ach.achievement_title}</strong>
                                        <br>
                                        ${ach.company_name}
                                        <br>
                                        ${ach.achievement_year}
                                        <br>
                                        ${ach.additional_information}
                                     </div>
                                    `
                        )
                        .join("");

                const skillsElement =
                    detailModal.querySelector("#freelance_skill");
                skillsElement.innerHTML =
                    freelancer.data.freelancer_profile.skills
                        .map(
                            (skill) => `
                                <span class="px-2 py-1 rounded-md border border-gray-300 mx-1">
                                  ${skill.skill_name}
                                </span>
                              `
                        )
                        .join("");

                detailModal.classList.remove("hidden");
            } else {
                console.error("Detail modal element not found.");
            }
        })
        .catch((error) => {
            console.error(`Error fetching job with ID ${freelanceId}:`, error);
        });
}

/**
 * Open and close detail lowongan modal
 */
function openDetailfreelancer() {
    const modal = document.getElementById("detailFreelancerModal");
    if (modal) {
        modal.classList.remove("hidden");
    } else {
        console.error("Detail Lowongan Modal not found!");
    }
}

function closeDetailfreelancer() {
    const modal = document.getElementById("detailFreelancerModal");
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
            openDetailfreelancer();
        }
    });

    const closeModalButtons = document.querySelectorAll(
        "#closeDetailFreelancer"
    );
    closeModalButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            closeDetailfreelancer();
        });
    });

    window.addEventListener("click", (event) => {
        const modal = document.getElementById("detailLowonganModal");
        if (event.target === modal) {
            closeDetailfreelancer();
        }
    });
}

document.addEventListener("DOMContentLoaded", initializeModalDetails);
