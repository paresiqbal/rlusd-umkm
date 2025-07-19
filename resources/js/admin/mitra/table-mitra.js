// Library
import { Grid } from "gridjs";
import "gridjs/dist/theme/mermaid.css";
import axios from "axios";

// Utility
import { formatDate, partnerStatusFormatter } from "../../utils/formatter.js";

// Modal
import { actionMenu } from "./action-menu.js";
import { fetchMitraById } from "./detail-modal.js";
import { blockMitra, unBlockMitra } from "./mitra-status.js";
import { deleteMitra } from "./delete-mitra.js"; // added import

let currentGrid = null;

export default function renderGrid(partnerData, rowsPerPage = 8) {
    if (currentGrid) {
        currentGrid.destroy();
    }

    const gridData = partnerData.map((partner, index) => [
        partner.user_id,
        index + 1,
        partner.partner_profile.partner_name,
        partner.email,
        formatDate(partner.created_at),
        partnerStatusFormatter(partner.is_active),
        { id: partner.user_id, isActive: partner.is_active }, // updated cell for "Aksi"
        formatDate(partner.email_verified_at),
    ]);

    currentGrid = new Grid({
        columns: [
            { name: "Partners Id", hidden: true },
            { name: "No", width: "60px" },
            "Mitra",
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

export function fetchPartners(
    is_active = null,
    province_id = null,
    district_id = null
) {
    axios
        .get("/admin/partners/fetch", {
            params: {
                province_id: province_id,
                district_id: district_id,
            },
        })
        .then((response) => {
            const partners = response.data.data;
            console.log(partners);

            // Optionally filter by active status
            let filteredPartner =
                is_active !== null
                    ? partners.filter(
                          (partner) => partner.is_active === is_active
                      )
                    : partners;

            // Sort partners in descending order based on registration date (created_at)
            filteredPartner.sort(
                (a, b) =>
                    new Date(b.created_at).getTime() -
                    new Date(a.created_at).getTime()
            );

            renderGrid(
                filteredPartner,
                parseInt(document.getElementById("rowsPerPage").value)
            );
        })
        .catch((error) => {
            console.error("Error fetching partners:", error);
            alert("Failed to fetch partners. Please try again.");
        });
}

document.getElementById("provinceFilter").addEventListener("change", (e) => {
    let province_id = e.target.value || null;
    fetchPartners(null, province_id);

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

    fetchPartners(null, province_id, district_id);
});

function initializeApp() {
    fetchPartners();

    document.getElementById("rowsPerPage").addEventListener("change", (e) => {
        fetchPartners();
    });

    // Desktop tabs handler
    document.querySelectorAll(".sm\\:flex a").forEach((tab) => {
        tab.addEventListener("click", (e) => {
            e.preventDefault();
            const status = e.target.dataset.status;

            let is_active = null;
            if (status === "true") is_active = true;
            if (status === "false") is_active = false;

            fetchPartners(is_active);

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
        fetchPartners(is_active);
    });

    // Detail button handler
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("detail-mitra-btn")) {
            const partnerId = e.target.getAttribute("data-mitra-id");
            partnerId && fetchMitraById(partnerId);
        }
    });

    // Pass id to block mitra modal
    document
        .getElementById("blockMitra")
        .addEventListener("click", function () {
            const partnerId = this.getAttribute("data-mitra-id");

            blockMitra(partnerId, fetchPartners);

            const modal = document.getElementById("blockMitraModal");
            modal.classList.add("hidden");
        });

    // Pass id to unblock mitra modal
    document
        .getElementById("unBlockMitra")
        .addEventListener("click", function () {
            const partnerId = this.getAttribute("data-mitra-id");

            unBlockMitra(partnerId, fetchPartners);

            const modal = document.getElementById("unBlockMitraModal");
            modal.classList.add("hidden");
        });

    // Pass id to delete mitra modal
    document
        .getElementById("deleteMitra")
        .addEventListener("click", function () {
            const partnerId = this.getAttribute("data-mitra-id");

            deleteMitra(partnerId, fetchPartners); // changed from unBlockMitra to deleteMitra

            const modal = document.getElementById("deleteMitraModal");
            modal.classList.add("hidden");
        });
}

document.addEventListener("DOMContentLoaded", initializeApp);
