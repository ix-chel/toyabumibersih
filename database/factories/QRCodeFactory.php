<?php

namespace Database\Factories;

use App\Models\QRCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class QRCodeFactory extends Factory
{
    protected $model = QRCode::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->uuid(),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'store_id' => \App\Models\Store::factory(),
        ];
    }
} 