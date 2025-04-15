<?php

namespace Database\Factories;

use App\Models\MaintenanceReportPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceReportPhotoFactory extends Factory
{
    protected $model = MaintenanceReportPhoto::class;

    public function definition()
    {
        return [
            'report_id' => \App\Models\MaintenanceReport::factory(),
            'file_path' => $this->faker->imageUrl(),
        ];
    }
} 