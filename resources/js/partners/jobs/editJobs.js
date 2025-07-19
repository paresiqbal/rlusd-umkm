import axios from "axios";
import { Notyf } from "notyf";

// Initialize Notyf for notifications
const notyf = new Notyf();

const editProvinceSelect = document.getElementById("edit_select_province");
const editDistrictSelect = document.getElementById("edit_select_district");
const editSubdistrictSelect = document.getElementById(
    "edit_select_subdistrict"
);

// Add this function to handle location loading for edit modal
async function loadEditLocations(provinceId, districtId, subdistrictId) {
    try {
        // Load districts
        const districtsResponse = await axios.get(`/districts/${provinceId}`);
        editDistrictSelect.innerHTML = districtsResponse.data
            .map(
                (district) =>
                    `<option value="${district.district_id}" ${
                        district.district_id == districtId ? "selected" : ""
                    }>
                ${district.district_name}
            </option>`
            )
            .join("");

        // Load subdistricts
        const subdistrictsResponse = await axios.get(
            `/subdistricts/${districtId}`
        );
        editSubdistrictSelect.innerHTML = subdistrictsResponse.data
            .map(
                (subdistrict) =>
                    `<option value="${subdistrict.subdistrict_id}" ${
                        subdistrict.subdistrict_id == subdistrictId
                            ? "selected"
                            : ""
                    }>
                ${subdistrict.subdistrict_name}
            </option>`
            )
            .join("");
    } catch (error) {
        console.error("Error loading locations:", error);
        notyf.error("Gagal memuat data lokasi");
    }
}

// Function to initialize edit job functionality
export function initializeEditJob() {
    document.addEventListener("click", function (event) {
        if (event.target.closest(".edit-job-btn")) {
            const button = event.target.closest(".edit-job-btn");
            const jobId = button.getAttribute("data-job-id");

            axios
                .get(`/partner/jobs/${jobId}`)
                .then((response) => {
                    const job = response.data.data;

                    // Populate form fields with the job data
                    document.getElementById("edit_post_job_id").value =
                        job.post_job_id;
                    document.getElementById("edit_role").value = job.role;
                    document.getElementById("edit_job_desc").value =
                        job.job_desc;
                    document.getElementById("edit_number_sdm").value =
                        job.number_sdm;
                    document.getElementById("edit_select_education").value =
                        job.min_education_id;
                    document.getElementById("edit_min_salary").value =
                        job.min_salary;
                    document.getElementById("edit_max_salary").value =
                        job.max_salary;
                    document.getElementById("editHiddenSalary").checked =
                        job.is_hidden_salary;
                    document.getElementById("edit_select_employment").value =
                        job.employment_type_id;
                    document.getElementById("edit_job_category").value =
                        job.job_category_id;

                    editProvinceSelect.value = job.province_id;
                    editDistrictSelect.value = job.district_id;
                    editSubdistrictSelect.value = job.subdistrict_id;
                    loadEditLocations(
                        job.province_id,
                        job.district_id,
                        job.subdistrict_id
                    );

                    document.getElementById("edit_address").value = job.address;
                    document.getElementById("edit_select_job_type").value =
                        job.job_type_id;
                    document.getElementById("edit_qualifications").value =
                        job.qualifications;
                    document
                        .getElementById("edit_skills")
                        .tomselect.setValue(
                            job.skills.map((skill) => skill.skill_id)
                        );

                    // Set the form action to include the job ID
                    document.getElementById(
                        "editJobForm"
                    ).action = `/partner/jobs/update/${jobId}`;

                    // Show the modal
                    openEditLowonganModal();
                })
                .catch((error) => {
                    console.error("Error fetching job details:", error);
                    notyf.error("Gagal Memperbarui Lowongan");
                });
        }
    });
}

// Add event listeners for location changes in edit modal
editProvinceSelect?.addEventListener("change", async () => {
    const provinceId = editProvinceSelect.value;
    try {
        const response = await axios.get(`/districts/${provinceId}`);
        editDistrictSelect.innerHTML = response.data
            .map(
                (district) =>
                    `<option value="${district.district_id}">${district.district_name}</option>`
            )
            .join("");
        editSubdistrictSelect.innerHTML = "";
    } catch (error) {
        console.error("Error loading districts:", error);
    }
});

editDistrictSelect?.addEventListener("change", async () => {
    const districtId = editDistrictSelect.value;
    try {
        const response = await axios.get(`/subdistricts/${districtId}`);
        editSubdistrictSelect.innerHTML = response.data
            .map(
                (subdistrict) =>
                    `<option value="${subdistrict.subdistrict_id}">${subdistrict.subdistrict_name}</option>`
            )
            .join("");
    } catch (error) {
        console.error("Error loading subdistricts:", error);
    }
});

// Function to open the edit modal
function openEditLowonganModal() {
    const modal = document.getElementById("editLowonganModal");
    if (modal) {
        modal.classList.remove("hidden");
    } else {
        console.error("Edit Lowongan Modal not found!");
    }
}

// Function to close the edit modal
function closeEditLowonganModal() {
    const modal = document.getElementById("editLowonganModal");
    if (modal) {
        modal.classList.add("hidden");
    } else {
        console.error("Edit Lowongan Modal not found!");
    }
}

// Initialize modal control events
function initializeModalEdit() {
    const openModalButtons = document.querySelectorAll(".open-edit-modal");
    document.addEventListener("click", (event) => {
        if (event.target.closest(".open-edit-modal")) {
            openEditLowonganModal();
        }
    });

    const closeModalButtons = document.querySelectorAll("#closeEditLowongan");
    closeModalButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            closeEditLowonganModal();
        });
    });

    window.addEventListener("click", (event) => {
        const modal = document.getElementById("editLowonganModal");
        if (event.target === modal) {
            closeEditLowonganModal();
        }
    });
}

// Initialize modal events on DOM content loaded
document.addEventListener("DOMContentLoaded", initializeModalEdit);

// Initialize edit job functionality on DOM content loaded
document.addEventListener("DOMContentLoaded", initializeEditJob);
