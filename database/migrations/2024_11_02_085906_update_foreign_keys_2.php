<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("partner_profiles", function (Blueprint $table) {
            $table->foreign('subdistrict_id')->references('subdistrict_id')->on('subdistricts')->nullOnDelete();
            $table->foreign('file_photo_id')->references('file_id')->on('files')->nullOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreign('approved_by')->references('user_id')->on('users')->nullOnDelete();
            $table->foreign('business_class_id')->references('business_class_id')->on('business_classes')->nullOnDelete();
            $table->foreign('partner_sector_id')->references('sector_id')->on('sectors')->nullOnDelete();
        });

        Schema::table("post_jobs", function (Blueprint $table) {
            $table->foreign('employment_type_id')->references('employment_type_id')->on('employment_types')->nullOnDelete();
            $table->foreign('job_type_id')->references('job_type_id')->on('job_types')->nullOnDelete();
            $table->foreign('job_category_id')->references('sector_id')->on('sectors')->nullOnDelete();
            $table->foreign('subdistrict_id')->references('subdistrict_id')->on('subdistricts')->nullOnDelete();
            $table->foreign('created_by')->references('user_id')->on('users')->cascadeOnDelete();
            $table->foreign('approved_by')->references('user_id')->on('users')->nullOnDelete();
        });

        Schema::table("post_jobs_skills", function (Blueprint $table) {
            $table->foreign('post_job_id')->references('post_job_id')->on('post_jobs')->onDelete('cascade');
            $table->foreign('skill_id')->references('skill_id')->on('skills');
        });

        Schema::table("admin_profiles", function (Blueprint $table) {
            $table->foreign('file_photo_id')->references('file_id')->on('files')->nullOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });

        Schema::table("applications", function (Blueprint $table) {
            $table->foreign('post_job_id')->references('post_job_id')->on('post_jobs')->cascadeOnDelete();
            $table->foreign('applicant_id')->references('user_id')->on('users')->cascadeOnDelete();
        });

        Schema::table("application_logs", function (Blueprint $table) {
            $table->foreign('application_id')->references('application_id')->on('applications')->cascadeOnDelete();
            $table->foreign('trigger_id')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
