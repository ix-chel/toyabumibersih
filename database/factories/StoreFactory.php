<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Store',
            'store_code' => strtoupper('STR-' . $this->faker->unique()->bothify('###??')),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'province' => $this->faker->state(),
            'phone' => $this->faker->phoneNumber(),
            'supervisor_name' => $this->faker->name(),
            'supervisor_email' => $this->faker->unique()->safeEmail(),
            'supervisor_phone' => $this->faker->phoneNumber(),
            'company_id' => Company::factory(), // auto bikin company kalau belum ada
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'joined_at' => $this->faker->date(),
        ];
    }
}
