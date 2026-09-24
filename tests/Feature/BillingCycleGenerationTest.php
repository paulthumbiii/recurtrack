<?php

use App\Models\Business;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\BillingCycle;

it('generates a due billing cycle based on plan price', function () {
    $business = Business::factory()->create();
    $plan = Plan::factory()->create([
        'business_id' => $business->id,
        'price' => 2000,
        'billing_frequency' => 'monthly',
    ]);
    $subscriber = Subscriber::factory()->create([
        'business_id' => $business->id,
        'plan_id' => $plan->id,
        'status' => 'active',
        'start_date' => now()->subDays(1),
    ]);

    $this->artisan('billing:generate-cycles');

    $cycle = $subscriber->billingCycles()->first();

    expect($cycle)->not->toBeNull();
    expect((float) $cycle->amount_due)->toBe(2000.0);
});

it('flags a pending billing cycle as overdue once its due date has passed', function () {
    $subscriber = Subscriber::factory()->create(['start_date' => now()->subMonths(2)]);
    $cycle = BillingCycle::factory()->create([
        'subscriber_id' => $subscriber->id,
        'status' => 'pending',
        'due_date' => now()->subDays(3),
    ]);

    $this->artisan('billing:generate-cycles');

    expect($cycle->fresh()->status)->toBe('overdue');
});