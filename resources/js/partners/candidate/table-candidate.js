// Library
import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import axios from "axios";

// Utility
import { candidateStatusFormatter, formatDate } from "../../utils/formatter.js";

// Modal
import { actionMenu } from "./action-menu.js";

// services
import { fetchCandidateById } from "./detailCandidate.js";
import { deleteJob } from "./deleteJob.js";

let currentGrid = null;

export default function renderGrid(candidatesData, rowsPerPage = 8) {
    if (currentGrid) {
        currentGrid.destroy();
    }

    const gridData = candidatesData.map((candidate, index) => [
        candidate.user.user_id,
        index + 1,
        candidate.user.freelancer_profile.name,
        formatDate(candidate.created_at),
        candidate.job.role,
        candidate.status,
        candidate.application_id,
    ]);

    currentGrid = new Grid({
        columns: [
            { name: "Application Id", hidden: true },
            { name: "No", width: "60px" },
            "Nama Kandidat",
            "Tanggal Melamar",
            "Lowongan Dilamar",
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
            { name: "User Id", hidden: true },
        ],
        data: gridData,
        pagination: { limit: rowsPerPage },
        resizable: true,
        search: true,
        sort: true,
    }).render(document.getElementById("wrapper"));
}

/**
 * Fetch candidates data
 */
export function fetchCandidates(status = "") {
    axios
        .get("/partner/candidates/fetch", {
            params: { status: status !== "semua" ? status : "" },
        })
        .then((response) => {
            let candidates = response.data.data;

            // Filter candidates based on status if provided.
            const filteredCandidates = status
                ? candidates.filter((candidate) => candidate.status === status)
                : candidates;

            // Sort candidates in descending order by created_at date.
            filteredCandidates.sort(
                (a, b) =>
                    new Date(b.created_at).getTime() -
                    new Date(a.created_at).getTime()
            );

            renderGrid(
                filteredCandidates,
                parseInt(document.getElementById("rowsPerPage").value)
            );
        })
        .catch((error) => {
            console.error("Error fetching candidates:", error);
            alert("Failed to fetch candidates. Please try again.");
        });
}

function initializeApp() {
    fetchCandidates();

    document.getElementById("rowsPerPage").addEventListener("change", (e) => {
        fetchCandidates();
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

            fetchCandidates(status);

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

    // Handle tab change event for mobile select
    document.getElementById("tabs").addEventListener("change", (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        let status = selectedOption
            .getAttribute("data-status")
            .trim()
            .toLowerCase();

        if (status === "semua") {
            status = "";
        }

        fetchCandidates(status);
    });

    // pass id to detail job buttons
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("detail-job-btn")) {
            const applicationId = e.target.getAttribute("data-job-id");
            if (applicationId) {
                fetchCandidateById(applicationId, fetchCandidates);
            } else {
                console.error("Application Id is missing.");
            }
        }
    });

    // pass id to delete job
    document
        .getElementById("confirmDeleteButton")
        .addEventListener("click", function () {
            const applicationId = this.getAttribute("data-job-id");

            deleteJob(applicationId, fetchCandidateById);

            const modal = document.getElementById("deleteConfirmationModal");
            modal.classList.add("hidden");
        });
}

document.addEventListener("DOMContentLoaded", initializeApp);
