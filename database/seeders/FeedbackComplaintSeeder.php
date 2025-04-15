<?php

namespace Database\Seeders;

use App\Models\FeedbackComplaint;
use Illuminate\Database\Seeder;

class FeedbackComplaintSeeder extends Seeder
{
    public function run()
    {
        FeedbackComplaint::factory()->count(10)->create();
    }
}
