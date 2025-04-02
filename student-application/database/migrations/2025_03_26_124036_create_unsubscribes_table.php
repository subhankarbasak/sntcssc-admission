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
        Schema::create('unsubscribes', function (Blueprint $table) {
            $table->id();$table->string('email')->index(); // Email that unsubscribed
            $table->string('email_type')->nullable(); // Type of email (e.g., 'registration', 'application_status', 'payment_status')
            $table->timestamp('unsubscribed_at')->useCurrent(); // When they unsubscribed
            $table->string('ip_address')->nullable(); // Optional: IP address for tracking
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unsubscribes');
    }
};
