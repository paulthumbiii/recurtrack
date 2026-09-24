<?php

namespace Database\Factories;

use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'name' => fake()->words(2, true).' Plan',
            'price' => fake()->randomFloat(2, 500, 5000),
            'billing_frequency' => fake()->randomElement(['weekly', 'monthly', 'annually']),
        ];
    }
}