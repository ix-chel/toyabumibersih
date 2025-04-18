<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'role_name' => $this->faker->unique()->randomElement(['Admin', 'Technician', 'Manager', 'Staff']),
            'description' => $this->faker->sentence(),
        ];
    }
} 