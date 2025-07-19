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
        Schema::table("users", function (Blueprint $table) {
            $table->foreign('role_id')->references('role_id')->on('roles')->nullOnDelete();
            $table->foreign('created_by')->references('user_id')->on('users')->nullOnDelete();
        });

        Schema::table("files", function (Blueprint $table) {
            $table->foreign('created_by')->references('user_id')->on('users')->nullOnDelete();
        });

        Schema::table("freelancer_profiles", function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('subdistrict_id')->references('subdistrict_id')->on('subdistricts')->nullOnDelete();
            $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('file_photo_id')->references('file_id')->on('files')->nullOnDelete();
            $table->foreign('file_cv_id')->references('file_id')->on('files')->nullOnDelete();
        });

        Schema::table('freelancer_profile_skills', function (Blueprint $table) {
            $table->foreign('skill_id')->references('skill_id')->on('skills')->onDelete('cascade');
            $table->foreign('freelancer_profile_id')->references('freelancer_profile_id')->on('freelancer_profiles')->onDelete('cascade');
        });

        Schema::table("freelancer_experiences", function (Blueprint $table) {
            $table->foreign('freelancer_profile_id')->references('freelancer_profile_id')->on('freelancer_profiles')->onDelete('cascade');
        });

        Schema::table("freelancer_educations", function (Blueprint $table) {
            $table->foreign('freelancer_profile_id')->references('freelancer_profile_id')->on('freelancer_profiles')->onDelete('cascade');
        });

        Schema::table("freelancer_experiences_skills", function (Blueprint $table) {
            $table->foreign('freelancer_experience_id')->references('freelancer_experience_id')->on('freelancer_experiences')->onDelete('cascade');
            $table->foreign('skill_id')->references('skill_id')->on('skills');
        });

        Schema::table("districts", function (Blueprint $table) {
            $table->foreign('province_id')->references('province_id')->on('provinces')->onDelete('cascade');
        });
        Schema::table("provinces", function (Blueprint $table) {
            $table->foreign('country_id')->references('country_id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        // For freelancer_profiles table
        Schema::table("freelancer_profiles", function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['approved_by']);
        });

        // For freelancer_portofolios table
        Schema::table("freelancer_portofolios", function (Blueprint $table) {
            $table->dropForeign(['freelancer_profile_id']);
        });

        // For freelancer_jobs table
        Schema::table("freelancer_jobs", function (Blueprint $table) {
            $table->dropForeign(['freelancer_profile_id']);
        });

        // For freelancer_portofolio_skills table
        Schema::table("freelancer_portofolio_skills", function (Blueprint $table) {
            $table->dropForeign(['freelancer_portofolio_id']);
            $table->dropForeign(['skill_id']);
        });

        // For freelancer_job_skills table
        Schema::table("freelancer_job_skills", function (Blueprint $table) {
            $table->dropForeign(['freelancer_job_id']);
            $table->dropForeign(['skill_id']);
        });

    }
};
