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
        Schema::create('research_submissions', function (Blueprint $table) {
            $table->string('serial_number')->unique();
            $table->string('article_title');
            $table->string('sub_theme');
            $table->text('abstract');
            $table->json('keywords');
            $table->string('pdf_document_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_submissions');
    }
};
