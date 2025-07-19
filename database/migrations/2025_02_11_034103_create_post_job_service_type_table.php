<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostJobServiceTypeTable extends Migration
{
    public function up(): void
    {
        Schema::create('post_job_service_type', function (Blueprint $table) {
            $table->unsignedBigInteger('post_job_id');
            $table->unsignedBigInteger('service_type_id');
            $table->timestamps();

            $table->foreign('post_job_id')
                ->references('post_job_id')->on('post_jobs')
                ->onDelete('cascade');

            $table->foreign('service_type_id')
                ->references('service_type_id')->on('service_types')
                ->onDelete('cascade');

            $table->primary(['post_job_id', 'service_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_job_service_type');
    }
}
