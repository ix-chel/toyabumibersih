<?php

namespace Database\Factories;

use App\Models\AuditTrail;
use App\Models\User; // Import User model untuk relasi
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditTrailFactory extends Factory
{
    protected $model = AuditTrail::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Relasi ke User
            'action' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
