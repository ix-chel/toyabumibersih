<?php

namespace Database\Factories;

use App\Models\MaintenancePartUsed;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenancePartUsedFactory extends Factory
{
    protected $model = MaintenancePartUsed::class;

    public function definition()
    {
        return [
            'report_id' => \App\Models\MaintenanceReport::factory(),
            'part_name' => $this->faker->word(),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
} 