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
        Schema::create('third_party_logins', function (Blueprint $table) {
            $table->id("third_party_id");
            $table->string("type")->nullable();
            $table->string("third_party_user_id")->nullable();
            $table->string("username")->nullable();
            $table->string("email")->nullable();
            $table->string("token")->nullable();
            $table->string("refresh_token")->nullable();
            $table->string("data", 500)->nullable();
            $table->unsignedBigInteger("user_id");
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('third_party_login');
    }
};
