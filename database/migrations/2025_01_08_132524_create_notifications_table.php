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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('notifiable_id');  // Change it to string
            $table->string('notifiable_type'); // Ensure type is also string if needed
            $table->string('message')->nullable();  // Existing message field
            $table->string('link')->nullable();  // Optional link field
            $table->boolean('read')->default(false);  // Track if the notification is read
            $table->timestamp('read_at')->nullable();
            $table->string('type')->nullable();  // Type of notification (optional)
            $table->json('data');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
