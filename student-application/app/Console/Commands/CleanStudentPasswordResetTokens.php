<?php

// app/Console/Commands/CleanStudentPasswordResetTokens.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanStudentPasswordResetTokens extends Command
{
    protected $signature = 'student:clean-password-tokens';
    protected $description = 'Remove expired student password reset tokens';

    public function handle()
    {
        try {
            DB::table('student_password_reset_tokens')
                ->where('created_at', '<', Carbon::now()->subMinutes(60))
                ->delete();

            $this->info('Expired student password reset tokens cleaned successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to clean student password reset tokens', [
                'error' => $e->getMessage()
            ]);
            $this->error('Failed to clean expired tokens.');
        }
    }
}