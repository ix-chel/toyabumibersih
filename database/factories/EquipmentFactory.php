<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'store_id' => Store::factory(), // otomatis bikin store kalau belum ada
            'name' => $this->faker->randomElement([
                'Pompa Air', 
                'Filter Karbon', 
                'UV Sterilizer', 
                'Tangki Penyimpanan', 
                'Pipa PVC'
            ]),
            'serial_number' => strtoupper($this->faker->unique()->bothify('EQP-####-??')),
            'status' => $this->faker->randomElement(['active', 'maintenance', 'retired']),
            'installed_at' => $this->faker->date(),
        ];
    }
}
