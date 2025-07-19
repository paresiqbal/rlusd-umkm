import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { resolve } from "path";

export default defineConfig({
    plugins: [
        laravel({
            buildDirectory: "build/appl",
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                // Admin JS Source
                "resources/js/admin/mitra/table-mitra.js",
                "resources/js/admin/mitra/mitra-status.js",
                "resources/js/admin/mitra/modal-handler.js",
                "resources/js/admin/mitra/delete-mitra.js",
                "resources/js/admin/freelance/table-freelance.js",
                "resources/js/admin/freelance/modal-handler.js",
                "resources/js/admin/freelance/freelancer-status.js",
                "resources/js/admin/freelance/delete-freelancer.js",
                "resources/js/admin/candidate/table-candidate.js",
                "resources/js/admin/vacancy/table-vacancy.js",
                "resources/js/admin/vacancy/modal-handler.js",
                // Partner JS Source
                "resources/js/partners/candidate/table-candidate.js",
                "resources/js/partners/candidate/modal-handler.js",
                "resources/js/partners/jobs/table-jobs.js",
                "resources/js/partners/jobs/modal-handler.js",
                "resources/js/partners/profiles/edit-profile.js",
                "resources/js/partners/profiles/edit-about.js",
                "resources/js/partners/profiles/edit-pic.js",
                "resources/js/partners/profiles/edit-website.js",
                "resources/js/partners/jobs/editJobs.js",
                "resources/js/partners/jobs/detailJobs.js",
                // Freelance JS Source
                "resources/js/user/jobs/apply-job.js",
                "resources/js/user/user-applications.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@": resolve(__dirname, "./resources/js"),
        },
    },
});
