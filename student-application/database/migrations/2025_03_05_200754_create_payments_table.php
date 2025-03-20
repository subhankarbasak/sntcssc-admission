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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['UPI', 'NEFT', 'IMPS', 'Direct Account Transfer']);
            $table->date('transaction_date');
            $table->string('transaction_id')->unique();
            $table->string('remarks')->nullable();
            $table->foreignId('screenshot_document_id')->nullable()->constrained('documents')->onDelete('set null');
            $table->enum('status', ['pending', 'under review', 'paid', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
