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
        Schema::create('proposal_abstract_submission_reviewers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for the pivot table
            $table->string('abstract_serial_number'); // References serial_number from research_submissions
            $table->string('reviewer_id'); // References reg_no from users
            $table->timestamps();

            // Foreign key constraints with custom names
            $table->foreign('abstract_serial_number', 'proposal_abstract_submission_reviewers_abstract_serial_number_fk')
                ->references('serial_number')
                ->on('research_submissions')
                ->onDelete('cascade');

            $table->foreign('reviewer_id', 'proposal_abstract_submission_reviewers_reviewer_id_fk')
                ->references('reg_no')
                ->on('users')
                ->onDelete('cascade');

            // Unique constraint to prevent duplicate assignments
            $table->unique(['abstract_serial_number', 'reviewer_id'], 'abstract_reviewer_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_abstract_submission_reviewers');
    }
};
