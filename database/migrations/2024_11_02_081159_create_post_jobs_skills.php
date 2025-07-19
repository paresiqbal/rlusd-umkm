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
        Schema::create('post_jobs_skills', function (Blueprint $table) {
            $table->unsignedBigInteger("skill_id");
            $table->unsignedBigInteger("post_job_id");
            $table->primary(["skill_id", "post_job_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_jobs_skills');
    }
};
