<?php

namespace Database\Seeders;

use App\Models\MaintenanceReport;
use Illuminate\Database\Seeder;

class MaintenanceReportSeeder extends Seeder
{
    public function run()
    {
        MaintenanceReport::factory()->count(30)->create();
    }
} 