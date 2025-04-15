<?php

namespace Database\Seeders;

use App\Models\AuditTrail;
use Illuminate\Database\Seeder;

class AuditTrailSeeder extends Seeder
{
    public function run()
    {
        AuditTrail::factory()->count(100)->create();
    }
} 