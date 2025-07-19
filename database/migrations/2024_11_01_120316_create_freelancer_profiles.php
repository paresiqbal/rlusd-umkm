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
        Schema::create('freelancer_profiles', function (Blueprint $table) {
            $table->id("freelancer_profile_id");
            $table->string("name", 255);
            $table->string("birthplace", 255)->nullable();
            $table->date("birthdate")->nullable();
            $table->string("phone_number", 25)->nullable();
            $table->unsignedTinyInteger("gender")->nullable()->comment("1 = male, 2 = female");
            $table->unsignedBigInteger("province_id")->nullable();
            $table->unsignedBigInteger("district_id")->nullable();
            $table->unsignedBigInteger("subdistrict_id")->nullable();
            $table->string("postal_code", 30)->nullable();
            $table->string("address", 255)->nullable();
            $table->text('about_me')->nullable();
            $table->unsignedInteger(column: "rating")->nullable();
            $table->unsignedBigInteger("file_photo_id")->nullable();
            $table->unsignedBigInteger("file_cv_id")->nullable();
            $table->unsignedBigInteger("file_skkni_id")->nullable();
            $table->unsignedBigInteger("file_skkk_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->string("status")->nullable();
            $table->string("main_skill", 191)->nullable();
            $table->timestamp("approved_at")->nullable();
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancer_profiles');
    }
};
