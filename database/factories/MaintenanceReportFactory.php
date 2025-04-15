<?php

namespace Database\Factories;

use App\Models\MaintenanceReport;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceReportFactory extends Factory
{
    protected $model = MaintenanceReport::class;

    public function definition()
    {
        return [
            'store_id' => \App\Models\Store::factory(),
            'user_id' => \App\Models\User::factory(),
            'status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed', 'Cancelled']),
            'notes' => $this->faker->paragraph(),
            'performed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
} 