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
        Schema::table('research_submissions', function (Blueprint $table) {
            $table->enum('final_status', [
                'submitted',
                'under_review',
                'rejected',
                'revision_required',
                'accepted',
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_submissions', function (Blueprint $table) {
            $table->string('final_status')->change();
        });
    }
};
