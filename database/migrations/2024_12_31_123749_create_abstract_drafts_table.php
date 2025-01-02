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
        Schema::create('abstract_drafts', function (Blueprint $table) {
            $table->id();
            $table->string('user_reg_no');
            $table->string('serial_number')->nullable();
            $table->string('title')->nullable();
            $table->string('sub_theme')->nullable();
            $table->text('abstract')->nullable();
            $table->json('keywords')->nullable();
            $table->json('authors')->nullable();
            $table->timestamps();

            $table->foreign('user_reg_no')->references('reg_no')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abstract_drafts');
    }
};
