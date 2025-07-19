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
        Schema::create('freelancer_experiences', function (Blueprint $table) {
            $table->id("freelancer_experience_id");
            $table->string("job_title", 100)->nullable();
            $table->string("company_name", 255)->nullable();
            $table->string("employment_type", 255)->nullable()->comment("full-time | part-time | contract | internship");
            $table->text("job_desc")->nullable();
            $table->text("project_link")->nullable();
            $table->string("country", 100)->nullable();
            $table->string("city", 100)->nullable();
            $table->date("start_at")->nullable();
            $table->date("end_at")->nullable();
            // $table->decimal("min_salary", 10, 2)->default(0)->nullable();
            // $table->decimal("max_salary", 10, 2)->default(0)->nullable();
            $table->unsignedBigInteger("freelancer_profile_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_jobs');
    }
};
