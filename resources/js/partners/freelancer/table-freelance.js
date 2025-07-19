// Library
import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import axios from "axios";

// Utility
import { formatDate, partnerStatusFormatter } from "../../utils/formatter.js";

// Modal
import { actionMenu } from "./action-menu.js";
import { fetchfreelancerById } from "./detail-modal.js";
import { blockFreelancer, unBlockFreelancer } from "./freelancer-status.js";
import { deleteFreelancer } from "./delete-freelancer.js";

let currentGrid = null;

export default function renderGrid(freelanceData, rowsPerPage = 8) {
    if (currentGrid) {
        currentGrid.destroy();
    }

    const gridData = freelanceData.map((freelancer, index) => [
        freelancer.user_id,
        index + 1,
        freelancer.username,
        freelancer.email,
        formatDate(freelancer.created_at),
        partnerStatusFormatter(freelancer.is_active),
        freelancer.user_id,
        formatDate(freelancer.email_verified_at),
    ]);

    currentGrid = new Grid({
        columns: [
            { name: "Freelancer Id", hidden: true },
            { name: "No", width: "60px" },
            "Username",
            "Email",
            "Tanggal Registrasi",
            {
                name: "Status",
                sort: false,
                formatter: (cell) => cell,
            },
            {
                name: "Aksi",
                sort: false,
                formatter: (cell) => gridjs.html(actionMenu(cell)),
            },
            { name: "Email Terverifikasi Di", hidden: true },
        ],
        data: gridData,
        pagination: { limit: rowsPerPage },
        resizable: true,
        search: true,
        sort: true,
    }).render(document.getElementById("wrapper"));
}

/**
 * Fetch freelancer data and sort in descending order based on registration date (created_at).
 */
export function fetchFreelancer(
    is_active = null,
    province_id = null,
    district_id = null
) {
    axios
        .get("/admin/freelancers/fetch", {
            params: {
                province_id: province_id,
                district_id: district_id,
            },
        })
        .then((response) => {
            const freelancers = response.data.data;

            let filteredFreelancer =
                is_active !== null
                    ? freelancers.filter(
                          (freelancer) => freelancer.is_active === is_active
                      )
                    : freelancers;

            // Sort in descending order by created_at date
            filteredFreelancer.sort(
                (a, b) =>
                    new Date(b.created_at).getTime() -
                    new Date(a.created_at).getTime()
            );

            renderGrid(
                filteredFreelancer,
                parseInt(document.getElementById("rowsPerPage").value)
            );
        })
        .catch((error) => {
            console.error("Error fetching freelancer:", error);
            alert("Failed to fetch freelancer. Please try again.");
        });
}

document.getElementById("provinceFilter").addEventListener("change", (e) => {
    let province_id = e.target.value || null;
    fetchFreelancer(null, province_id);

    axios.get(`/districts/${province_id}`).then((response) => {
        const districts = response.data;
        const districtSelect = document.getElementById("districtFilter");
        districtSelect.innerHTML = `<option value="">Semua</option>`;
        districts.forEach((district) => {
            districtSelect.innerHTML += `<option value="${district.district_id}">${district.district_name}</option>`;
        });
    });
});

document.getElementById("districtFilter").addEventListener("change", (e) => {
    let province_id = document.getElementById("provinceFilter").value || null;
    let district_id = e.target.value || null;

    fetchFreelancer(null, province_id, district_id);
});

function initializeApp() {
    fetchFreelancer();

    document.getElementById("rowsPerPage").addEventListener("change", (e) => {
        fetchFreelancer();
    });

    // Desktop tabs handler
    document.querySelectorAll(".sm\\:flex a").forEach((tab) => {
        tab.addEventListener("click", (e) => {
            e.preventDefault();
            const status = e.target.dataset.status;

            let is_active = null;
            if (status === "true") is_active = true;
            if (status === "false") is_active = false;

            fetchFreelancer(is_active);

            // Update tab styling
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

    // Mobile select handler
    document.getElementById("tabs").addEventListener("change", (e) => {
        const statusMap = {
            Semua: null,
            Aktif: true,
            "Tidak Aktif": false,
        };

        const is_active = statusMap[e.target.value];
        fetchFreelancer(is_active);
    });

    // Detail button handler
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("detail-freelancer-btn")) {
            const freelanceId = e.target.getAttribute("data-freelancer-id");
            if (freelanceId) {
                fetchfreelancerById(freelanceId);
            } else {
                console.error("Freelance ID is missing.");
            }
        }
    });

    // Block freelancer button handler
    document
        .getElementById("blockFreelancer")
        .addEventListener("click", function () {
            const freelancerId = this.getAttribute("data-freelancer-id");

            blockFreelancer(freelancerId, fetchFreelancer);

            const modal = document.getElementById("blockFreelancerModal");
            modal.classList.add("hidden");
        });

    // Unblock freelancer button handler
    document
        .getElementById("unBlockFreelancer")
        .addEventListener("click", function () {
            const freelancerId = this.getAttribute("data-freelancer-id");

            unBlockFreelancer(freelancerId, fetchFreelancer);

            const modal = document.getElementById("unBlockFreelancerModal");
            modal.classList.add("hidden");
        });

    // Delete freelancer button handler
    document
        .getElementById("deleteFreelancer")
        .addEventListener("click", function () {
            const freelancerId = this.getAttribute("data-freelancer-id");

            deleteFreelancer(freelancerId, fetchFreelancer);

            const modal = document.getElementById("deleteFreelancerModal");
            modal.classList.add("hidden");
        });
}

document.addEventListener("DOMContentLoaded", initializeApp);
