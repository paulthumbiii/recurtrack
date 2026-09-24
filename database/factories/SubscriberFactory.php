<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'plan_id' => Plan::factory(),
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'status' => 'active',
            'start_date' => now()->subMonths(2),
        ];
    }
}