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
        Schema::create('research_assessments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('abstract_submission_id'); // Foreign key
            $table->string('reviewer_reg_no');
            $table->string('user_reg_no'); // Foreign key
            $table->integer('thematic_score'); // Score for thematic
            $table->text('thematic_comments'); // Comments for thematic
            $table->integer('title_score'); // Score for title
            $table->text('title_comments'); // Comments for title
            $table->integer('objectives_score'); // Score for objectives
            $table->text('objectives_comments'); // Comments for objectives
            $table->integer('methodology_score'); // Score for methodology
            $table->text('methodology_comments'); // Comments for methodology
            $table->integer('output_score'); // Score for output
            $table->text('output_comments'); // Comments for output
            $table->text('general_comments'); // General comments
            $table->enum('correction_type', ['minor', 'major', 'reject']); // Correction type
            $table->text('correction_comments'); // Correction comments
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('abstract_submission_id')->references('serial_number')->on('abstract_submissions')->onDelete('cascade');
            $table->foreign('reviewer_reg_no')->references('reg_no')->on('users')->onDelete('cascade');
            $table->foreign('user_reg_no')->references('reg_no')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_assessments');
    }
};
