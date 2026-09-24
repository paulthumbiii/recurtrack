<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillingCycleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subscriber_id' => Subscriber::factory(),
            'amount_due' => fake()->randomFloat(2, 500, 5000),
            'due_date' => now()->addMonth(),
            'status' => 'pending',
        ];
    }
}