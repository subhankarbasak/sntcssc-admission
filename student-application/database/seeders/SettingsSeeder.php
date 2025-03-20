<?php

// database/seeders/SettingsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'app_name' => 'SNTCSSC Admission Test Portal',
            'title' => 'Welcome to SNTCSSC Admission Test Portal',
            'meta_title' => 'SNTCSSC Admission Test Portal - Home',
            'meta_description' => 'A professional web application built with Laravel',
            'language' => 'en',
            'date_format' => 'Y-m-d',
            'time_format' => 'H:i:s',
            'currency_symbol' => '₹',
            'copyright_text' => '© ' . date('Y') . ' SNTCSSC Admission Test Portal. All rights reserved.',
            'maintenance_mode' => false,
        ]);
    }
}