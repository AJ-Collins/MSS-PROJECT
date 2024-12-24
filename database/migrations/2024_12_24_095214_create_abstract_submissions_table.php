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
        Schema::create('abstract_submissions', function (Blueprint $table) {
            $table->string('serial_number')->primary()->unique();
            $table->string('title',500)->nullable();
            $table->string('sub_theme',500)->nullable();
            $table->text('abstract')->nullable();
            $table->json('keywords')->nullable();
            $table->boolean('approved')->default(false);
            $table->string('pdf_path')->nullable();
            $table->string('user_reg_no',500);
            $table->string('reviewer_reg_no')->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abstract_submissions');
    }
};
