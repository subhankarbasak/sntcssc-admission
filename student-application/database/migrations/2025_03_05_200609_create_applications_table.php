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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('advertisement_id')->constrained();
            $table->foreignId('advertisement_program_id')->constrained('advertisement_programs');
            $table->foreignId('student_profile_id')->constrained('student_profiles')->cascadeOnDelete();
            $table->string('application_number')->unique();
            $table->string('optional_subject')->nullable();
            $table->boolean('is_appearing_upsc_cse')->default(false);
            $table->unsignedTinyInteger('upsc_attempts_count')->default(0);
            $table->string('status')->default('draft')->comment('draft, submitted, under_review, approved, rejected, waitlisted');
            $table->string('payment_status')->default('pending')->comment('pending, paid, failed');
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
            
            // $table->unique(['student_id', 'advertisement_id', 'advertisement_program_id']); As issue with the migration failing due to a unique constraint name exceeding MySQL's identifier length limit

            $table->unique(
                ['student_id', 'advertisement_id', 'advertisement_program_id'],
                'applications_student_advertisement_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
