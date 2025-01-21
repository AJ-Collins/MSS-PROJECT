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
        Schema::table('abstract_submission_reviewers', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->text('decline_reason')->nullable();
            $table->timestamp('response_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abstract_submission_reviewers', function (Blueprint $table) {
            $table->dropColumn(['status', 'decline_reason', 'response_date']);
        });
    }
};
