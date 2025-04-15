<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'supervisor_name' => $this->faker->name(),
            'supervisor_phone' => $this->faker->phoneNumber(),
            'company_phone' => $this->faker->phoneNumber(),
            'company_email' => $this->faker->companyEmail(),
            'supervisor_email' => $this->faker->companyEmail(),
            'address' => $this->faker->address(),
            'total_store' => $this->faker->numberBetween(1, 100), // Contoh total store antara 1 hingga 100
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'joined_at' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
