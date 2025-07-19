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
        Schema::create('files', function (Blueprint $table) {
            $table->id("file_id");
            $table->string("filename")->nullable();
            $table->string('original_filename')->nullable();
            $table->string("path")->nullable();
            $table->string("extension")->nullable();
            $table->string("mime_type")->nullable();
            $table->string("type")->nullable();
            $table->unsignedBigInteger("size");
            $table->string("description", 500)->nullable();
            $table->string("fileable_id", 100);
            $table->string("fileable_type", 255);
            $table->string("uploaded_from", 255)->nullable();
            $table->unsignedBigInteger("created_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
