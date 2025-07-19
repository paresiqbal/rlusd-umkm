// Library
import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import axios from "axios";
import { Notyf } from "notyf";

// Utility
import { candidateStatusFormatter, formatDate } from "../../utils/formatter.js";

// Modal
import { actionMenu } from "./action-menu.js";

// Service
import { fetchJobById } from "./detailJobs.js";
import { deleteJob } from "./deleteJob.js";
import { initializeEditJob } from "./editJobs.js";
import { tutupLowongan } from "./changeJobStatus.js";

let currentGrid = null;

export default function renderGrid(jobsData, rowsPerPage = 8) {
    if (currentGrid) {
        currentGrid.destroy();
    }

    const gridData = jobsData.map((job, index) => [
        index + 1,
        job.role,
        formatDate(job.created_at),
        job.applicant_count,
        job.status,
        { id: job.post_job_id, status: job.status }, // updated cell for Aksi column
        job.approved_at,
        job.job_desc,
        job.job_category_id,
        job.min_education_id,
        job.genders,
        job.education_name,
        job.min_salary,
        job.max_salary,
        job.employment_type_id,
        job.employment_type_name,
        job.skill_names,
        job.qualifications,
        job.job_type_id,
        job.job_type_name,
        job.country_id,
        job.province_id,
        job.district_id,
        job.address,
        job.updated_at,
        job.number_sdm,
        job.service_type_id,
    ]);

    currentGrid = new Grid({
        columns: [
            { name: "No", width: "60px" },
            "Judul Pekerjaan",
            "Tanggal Upload",
            "Pendaftar",
            {
                name: "Status",
                sort: false,
                formatter: (cell) => candidateStatusFormatter(cell),
            },
            {
                name: "Aksi",
                sort: false,
                formatter: (cell) => gridjs.html(actionMenu(cell)),
            },
            { name: "Deskripsi", hidden: true },
            { name: "Kategori Pekerjaan", hidden: true },
            { name: "Pendidikan Minimal", hidden: true },
            { name: "Gaji Minimal", hidden: true },
            { name: "Gaji Maximal", hidden: true },
            { name: "Jenis Pekerjaan", hidden: true },
            { name: "Jenis Layanan", hidden: true },
            { name: "Skill yang Dibutuhkan", hidden: true },
            { name: "Kualifikasi", hidden: true },
            { name: "Tipe Pekerjaan", hidden: true },
            { name: "Negara", hidden: true },
            { name: "Provinsi", hidden: true },
            { name: "Kabupaten", hidden: true },
            { name: "Alamat", hidden: true },
            { name: "Tanggal Update", hidden: true },
            { name: "Jumlah SDM", hidden: true },
        ],
        data: gridData,
        pagination: { limit: rowsPerPage },
        resizable: true,
        search: true,
        sort: true,
    }).render(document.getElementById("wrapper"));
}

/**
 * Fetch jobs data
 */
export function fetchJobs(status = "") {
    const notyf = new Notyf();

    axios
        .get("/partner/jobs/fetch", {
            params: { status: status !== "semua" ? status : "" },
        })
        .then((response) => {
            const jobs = response.data.data;
            console.log("Jobs data:", jobs);

            renderGrid(
                jobs,
                parseInt(document.getElementById("rowsPerPage").value)
            );
        })
        .catch((error) => {
            console.error("Error fetching jobs:", error);
            notyf.error("Gagal mengambil lowongan pekerjaan, coba lagi nanti.");
        });
}

function initializeApp() {
    initializeEditJob();

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
        const status = e.target.value;
        fetchJobs(status);
    });

    document.getElementById("tabs").addEventListener("change", (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const status = selectedOption
            .getAttribute("data-status")
            .trim()
            .toLowerCase();

        fetchJobs(status);
    });

    // pass id to detail job buttons
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

    // pass id to delete job
    document
        .getElementById("confirmDeleteButton")
        .addEventListener("click", function () {
            const jobId = this.getAttribute("data-job-id");

            deleteJob(jobId, fetchJobs);

            const modal = document.getElementById("deleteConfirmationModal");
            modal.classList.add("hidden");
        });

    // pass id to tutup lowongan
    document
        .getElementById("changeTutup")
        .addEventListener("click", function () {
            const jobId = this.getAttribute("data-job-id");

            tutupLowongan(jobId, fetchJobs);

            const modal = document.getElementById("tutupLowonganModal");
            modal.classList.add("hidden");
        });
}

document.addEventListener("DOMContentLoaded", initializeApp);
