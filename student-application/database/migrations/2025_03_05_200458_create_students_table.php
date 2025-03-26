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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('secondary_roll')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob');
            $table->string('gender')->comment('Male, Female, Others');
            $table->string('category')->nullable()->comment('UR, SC, ST, OBC A, OBC B');
            $table->string('cat_cert_no')->nullable();
            $table->date('cat_issue_date')->nullable();
            $table->string('cat_issue_by')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password');
            $table->longText('password_text')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
