// Library
import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import axios from "axios";

// Utility
import {
    approvedStatusFormatter,
    formatDate,
    jobApprovedFormarter,
} from "../../utils/formatter.js";

// Modal
import { actionMenu } from "./action-menu.js";

// Service
import { fetchJobById } from "./detailJobs.js";
import { deleteJob } from "./deleteJob.js";

let currentGrid = null;

export default function renderGrid(jobsData, rowsPerPage = 8) {
    if (currentGrid) {
        currentGrid.destroy();
    }

    const gridData = jobsData.map((job, index) => [
        job.post_job_id,
        index + 1,
        job.user.partner_profile.partner_name,
        job.role,
        formatDate(job.created_at),
        job.approved_at,
        job.status,
        job.post_job_id,
        job.approved_by,
        job.job_desc,
        job.job_category_id,
        job.min_education_id,
        job.education_name,
        job.min_salary,
        job.max_salary,
        job.employment_type_id,
        job.employment_type_name,
        job.skill_names &&
        Array.isArray(job.skill_names) &&
        job.skill_names.length > 0
            ? job.skill_names.join(", ")
            : "No skills specified",
        job.qualifications,
        job.job_type_id,
        job.job_type_name,
        job.country_id,
        job.province_id,
        job.city_id,
        job.address,
        job.updated_at,
    ]);

    currentGrid = new Grid({
        columns: [
            { name: "ID", hidden: true },
            { name: "No", width: "60px" },
            "Perusahaan",
            "Judul Pekerjaan",
            "Tanggal Upload",
            {
                name: "Disetujui Pada",
                sort: false,
                formatter: (cell) => formatDate(cell),
            },
            {
                name: "Status",
                sort: false,
                formatter: (cell) => approvedStatusFormatter(cell),
            },
            {
                name: "Aksi",
                sort: false,
                formatter: (cell) => gridjs.html(actionMenu(cell)),
            },
            { name: "Disetujui Oleh", hidden: true },
            { name: "Deskripsi", hidden: true },
            { name: "Kategori Pekerjaan", hidden: true },
            { name: "Pendidikan Minimal", hidden: true },
            { name: "Gaji Minimal", hidden: true },
            { name: "Gaji Maximal", hidden: true },
            { name: "Jenis Pekerjaan", hidden: true },
            { name: "Skill yang Dibutuhkan", hidden: true },
            { name: "Kualifikasi", hidden: true },
            { name: "Tipe Pekerjaan", hidden: true },
            { name: "Negara", hidden: true },
            { name: "Provinsi", hidden: true },
            { name: "Kota", hidden: true },
            { name: "Alamat", hidden: true },
            { name: "Tanggal Update", hidden: true },
        ],
        data: gridData,
        pagination: { limit: rowsPerPage },
        resizable: true,
        search: true,
        sort: true,
    }).render(document.getElementById("wrapper"));
}

/**
 * Fetch jobs data and sort in descending order by created_at field.
 */
export function fetchJobs(status = "") {
    axios
        .get("/admin/vacancies/fetch")
        .then((response) => {
            let jobs = response.data.data;
            console.log(jobs);

            // Filter jobs based on status if needed
            if (status) {
                jobs = jobs.filter((job) => job.status === status);
            }

            // Sort jobs in descending order based on creation date (created_at)
            jobs.sort(
                (a, b) =>
                    new Date(b.created_at).getTime() -
                    new Date(a.created_at).getTime()
            );

            renderGrid(
                jobs,
                parseInt(document.getElementById("rowsPerPage").value)
            );
        })
        .catch((error) => {
            console.error("Error fetching jobs:", error);
            alert("Failed to fetch jobs. Please try again.");
        });
}

function initializeApp() {
    fetchJobs();

    document.getElementById("rowsPerPage").addEventListener("change", (e) => {
        fetchJobs();
    });

    document.querySelectorAll(".sm\\:flex a").forEach((tab) => {
        tab.addEventListener("click", (e) => {
            e.preventDefault();

            let status = e.target
                .getAttribute("data-status")
                .trim()
                .toLowerCase();

            if (status === "semua") {
                status = "";
            }

            fetchJobs(status);

            document
                .querySelectorAll(".sm\\:flex a")
                .forEach((t) =>
                    t.classList.remove(
                        "bg-stone-100",
                        "border-b-4",
                        "border-primary-500"
                    )
                );
            e.target.classList.add(
                "bg-stone-100",
                "border-b-4",
                "border-primary-500"
            );
        });
    });

    // Handle tab change event
    document.getElementById("tabs").addEventListener("change", (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        let status = selectedOption
            .getAttribute("data-status")
            .trim()
            .toLowerCase();

        if (status === "semua") {
            status = "";
        }

        fetchJobs(status);
    });

    // Pass id to detail job buttons
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("detail-job-btn")) {
            const jobId = e.target.getAttribute("data-job-id");
            if (jobId) {
                fetchJobById(jobId);
            } else {
                console.error("Job ID is missing.");
            }
        }
    });

    // Pass id to delete job buttons
    document
        .getElementById("confirmDeleteButton")
        .addEventListener("click", function () {
            const jobId = this.getAttribute("data-job-id");

            deleteJob(jobId, fetchJobs);

            const modal = document.getElementById("deleteConfirmationModal");
            modal.classList.add("hidden");
        });
}

document.addEventListener("DOMContentLoaded", initializeApp);

// Add event listener to re-render grid when jobs are updated
document.addEventListener("jobsUpdated", () => {
    fetchJobs();
});
