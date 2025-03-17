<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdvertisementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $advertisements = [
            [
                'batch_id' => 1,
                'title' => 'SNTCSSC Composite Course 2026 Batch',
                'code' => 'sntcssc-admission-2026-batch',
                'application_start' => now(),
                'application_end' => now(),
                'status' => 'published',
                'instructions' => 'Please submit all required documents by the deadline to ensure timely processing.',
            ],
        ];

        DB::table('advertisements')->insert($advertisements);
    }
}
