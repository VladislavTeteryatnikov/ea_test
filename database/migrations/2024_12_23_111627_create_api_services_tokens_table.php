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
        Schema::create('api_services_tokens', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('api_service_id');
            $table->foreign('api_service_id')->references('id')->on('api_services');

            $table->unsignedBigInteger('token_id');
            $table->foreign('token_id')->references('id')->on('tokens');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_services_tokens');
    }
};
