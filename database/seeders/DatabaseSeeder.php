<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            StoreSeeder::class,
            EquipmentSeeder::class,
            QRCodeSeeder::class,
            MaintenanceReportSeeder::class,
            MaintenanceReportPhotoSeeder::class,
            MaintenancePartUsedSeeder::class,
            AuditTrailSeeder::class,
            FeedbackComplaintSeeder::class,
        ]);
    }
} 