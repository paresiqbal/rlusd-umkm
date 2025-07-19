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
        Schema::create('freelancer_educations', function (Blueprint $table) {
            $table->id("freelancer_educations_id");
            $table->string("school_name", 100)->nullable();
            $table->string("major", 255)->nullable();
            $table->text("education_desc")->nullable();
            $table->string("graduate_year", 50)->nullable();
            $table->unsignedBigInteger("freelancer_profile_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_experiences');
    }
};
