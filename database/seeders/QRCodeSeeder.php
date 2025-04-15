<?php

namespace Database\Seeders;

use App\Models\QRCode;
use Illuminate\Database\Seeder;

class QRCodeSeeder extends Seeder
{
    public function run()
    {
        QRCode::factory()->count(20)->create();
    }
} 