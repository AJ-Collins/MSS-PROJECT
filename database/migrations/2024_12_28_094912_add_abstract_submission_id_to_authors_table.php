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
        Schema::table('authors', function (Blueprint $table) {
            $table->string('abstract_submission_id')->nullable();
            $table->string('research_submission_id')->nullable();
    
            // Add the foreign key constraint
            $table->foreign('abstract_submission_id')->references('serial_number')->on('abstract_submissions')->onDelete('cascade');
            $table->foreign('research_submission_id')->references('serial_number')->on('research_submissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropForeign(['abstract_submission_id']);
            $table->dropColumn('abstract_submission_id');
            $table->dropForeign(['research_submission_id']);
            $table->dropColumn('research_submission_id');
        });
    }
};
