export function formatDate(isoDate) {
    if (!isoDate) return null;

    const date = new Date(isoDate);
    if (isNaN(date.getTime())) return null;

    const options = { year: "numeric", month: "long", day: "numeric" };
    return date.toLocaleDateString(undefined, options);
}

/**
 * Format semua status pekerjaan dan lowongan kandidat
 */
export const candidateStatusFormatter = (status) => {
    if (typeof status !== "string") {
        return gridjs.html(
            `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-orange-100 text-gray-800">Unknown Status</span>`
        );
    }

    const statusColors = {
        review_by_admin: "bg-yellow-500 text-white",
        rejected_by_admin: "bg-red-600 text-white",
        review_by_mitra: "bg-orange-400 text-white",
        rejected_by_mitra: "bg-orange-600 text-white",
        closed: "bg-red-500 text-white",
        accepted: "bg-green-500 text-white",
        completed: "bg-gray-300 text-white",
    };

    const classes =
        statusColors[status.toLowerCase()] || "bg-orange-100 text-gray-800";

    const formatStatus = (status) => {
        if (status === "review_by_admin" || status === "review_by_mitra") {
            return "Dalam Review";
        }

        if (status === "rejected_by_admin" || status === "rejected") {
            return "Ditolak";
        }

        if (status === "rejected_by_mitra" || status === "rejected") {
            return "Ditolak";
        }

        if (status === "closed") {
            return "Ditutup";
        }

        if (status === "accepted") {
            return "Diterima";
        }

        return status
            .toLowerCase()
            .split("_")
            .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
            .join(" ");
    };

    const formattedStatus = formatStatus(status);

    return gridjs.html(
        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg ${classes}">${formattedStatus}</span>`
    );
};

/**
 * Untuk format status jasa
 */
export const approvedStatusFormatter = (status) => {
    if (status === "review_by_admin") {
        return gridjs.html(
            `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-yellow-500 text-white">Dalam Review</span>`
        );
    }

    if (status === "reject_by_admin") {
        return gridjs.html(
            `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-red-500 text-white">Ditolak</span>`
        );
    }

    const formattedStatus = "Diterima";
    const classes = "bg-green-500 text-white";

    return gridjs.html(
        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg ${classes}">${formattedStatus}</span>`
    );
};
/**
 * Untuk format persetujuan jasa
 */
export const jobApprovedFormarter = (approved_at) => {
    if (approved_at === null) {
        return gridjs.html(
            `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg bg-yellow-500 text-white">Belum disetujui</span>`
        );
    }

    const formattedStatus = "Diterima";
    const classes = "bg-green-500 text-white";

    return gridjs.html(
        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg ${classes}">${formattedStatus}</span>`
    );
};

/**
 * Format salary to Indonesian Rupiah
 */
export function formatSalary(value) {
    const formattedValue = Number(value).toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 2,
    });

    return `Rp. ${formattedValue.replace("Rp", "").trim()}`;
}

/**
 *  Format status of a partner in admin dashboard
 */
export function partnerStatusFormatter(isActive) {
    const classes = isActive
        ? "bg-green-500 text-white"
        : "bg-red-500 text-white";
    const statusText = isActive ? "Aktif" : "Tidak Aktif";

    return gridjs.html(
        `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-lg ${classes}">${statusText}</span>`
    );
}
