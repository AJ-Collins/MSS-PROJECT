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
            $table->text('admin_comments')->nullable()->after('score'); 
            $table->text('reviewer_comments')->nullable()->after('admin_comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_submissions', function (Blueprint $table) {             
            $table->dropColumn(['admin_comments', 'reviewer_comments']);
        });
    }
};
