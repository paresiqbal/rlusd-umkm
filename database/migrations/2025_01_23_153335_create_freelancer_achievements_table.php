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
        Schema::create('freelancer_achievements', function (Blueprint $table) {
            $table->id('freelancer_achievements_id');
            $table->string('achievement_title', 255)->nullable();
            $table->unsignedBigInteger('achievement_year', 255)->nullable();
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger("freelancer_profile_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_achievements');
    }
};
