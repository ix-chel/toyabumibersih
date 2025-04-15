<?php

namespace Database\Seeders;

use App\Models\MaintenanceReportPhoto;
use Illuminate\Database\Seeder;

class MaintenanceReportPhotoSeeder extends Seeder
{
    public function run()
    {
        MaintenanceReportPhoto::factory()->count(50)->create();
    }
} 