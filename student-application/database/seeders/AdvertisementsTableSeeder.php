<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import the Carbon namespace

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Setting the start and end dates using Carbon
        $start_date = Carbon::createFromFormat('d.m.Y h:i A', '21.03.2025 11:00 AM');
        $end_date = Carbon::createFromFormat('d M Y h:i A', '21 April 2025 03:00 PM');

        // Define the start and end dates as strings
        $memo_date = '2025-03-20 19:00:00'; // MySQL format
        // $end_date = '2025-04-21 15:00:00'; // MySQL format

        $advertisements = [
            [
                'batch_id' => 1,
                'title' => 'SNTCSSC Composite Course 2026 Batch',
                'code' => 'sntcssc-admission-2026-batch',
                'slug' => 'sntcssc-admission-2026-batch',
                'memo_no' => '417/CEPM/02/Part-3/13-14',
                'published_date' => $memo_date,
                'application_start' => $start_date,
                'application_end' => $end_date,
                'status' => 'published',
                'instructions' => 'Please submit all required documents by the deadline to ensure timely processing.',
            ],
        ];

        DB::table('advertisements')->insert($advertisements);
    }
}
