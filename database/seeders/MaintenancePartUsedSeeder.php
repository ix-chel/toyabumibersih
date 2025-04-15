<?php

namespace Database\Seeders;

use App\Models\MaintenancePartUsed;
use Illuminate\Database\Seeder;

class MaintenancePartUsedSeeder extends Seeder
{
    public function run()
    {
        MaintenancePartUsed::factory()->count(40)->create();
    }
} 