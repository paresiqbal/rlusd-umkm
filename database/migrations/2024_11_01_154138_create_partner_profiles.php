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
        Schema::create('partner_profiles', function (Blueprint $table) {
            $table->id("partner_profile_id");
            $table->string("partner_name", 255);
            $table->string("phone_number", 25)->nullable();
            $table->unsignedBigInteger("province_id")->nullable();
            $table->unsignedBigInteger("district_id")->nullable();
            $table->unsignedBigInteger("subdistrict_id")->nullable();
            $table->unsignedBigInteger("organization_id")->nullable();
            $table->string("postal_code", 30)->nullable();
            $table->string("address", 255)->nullable();
            $table->unsignedInteger(column: "rating")->nullable();
            $table->unsignedBigInteger("business_class_id")->nullable();
            $table->unsignedBigInteger("partner_sector_id")->nullable();
            $table->unsignedBigInteger("file_photo_id")->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->timestamp("approved_at")->nullable();
            $table->unsignedBigInteger("approved_by")->nullable();
            $table->string("about_company", 255)->nullable();
            $table->string("pic_name", 255)->nullable();
            $table->string("pic_email", 255)->nullable();
            $table->string("pic_phone_number", 25)->nullable();
            $table->string("pic_position", 255)->nullable();
            $table->string("website", 255)->nullable();
            $table->timestamps();
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
