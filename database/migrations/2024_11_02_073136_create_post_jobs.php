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
        Schema::create('post_jobs', function (Blueprint $table) {
            $table->id("post_job_id");
            $table->string("role", 255)->nullable();
            $table->unsignedInteger("number_sdm")->nullable();
            $table->string('status')->default('review_by_admin');
            $table->text("job_desc")->nullable();
            $table->text("qualifications")->nullable();
            $table->unsignedInteger("employment_type_id")->nullable();
            $table->unsignedInteger('job_type_id')->nullable();
            $table->unsignedInteger("service_type_id")->nullable();
            $table->unsignedBigInteger("job_category_id")->nullable();
            $table->unsignedInteger("min_education_id")->nullable();
            $table->enum("genders", ['laki laki', 'perempuan', 'tidak ditentukan'])->nullable();
            $table->decimal("min_salary", 10, 2)->default(0);
            $table->decimal("max_salary", 10, 2)->default(0);
            $table->boolean("is_hidden_salary")->default(false);
            $table->unsignedBigInteger("country_id")->nullable();
            $table->unsignedBigInteger("province_id")->nullable();
            $table->unsignedBigInteger("district_id")->nullable();
            $table->unsignedBigInteger("subdistrict_id")->nullable();
            $table->string("address", 255)->nullable();
            $table->timestamp("approved_at")->nullable();
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->date("closed_post_at")->nullable();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_jobs');
    }
};
