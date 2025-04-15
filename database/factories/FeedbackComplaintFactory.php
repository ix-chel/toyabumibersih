<?php

namespace Database\Factories;

use App\Models\FeedbackComplaint;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackComplaintFactory extends Factory
{
    protected $model = FeedbackComplaint::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'type' => $this->faker->randomElement(['Feedback', 'Complaint']),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['Open', 'In Progress', 'Resolved', 'Closed']),
        ];
    }
}
