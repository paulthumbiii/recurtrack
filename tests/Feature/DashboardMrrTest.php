<?php

use App\Models\Business;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\User;

it('calculates MRR correctly across mixed billing frequencies', function () {
    $business = Business::factory()->create();
    $user = User::factory()->create(['business_id' => $business->id]);

    $monthlyPlan = Plan::factory()->create(['business_id' => $business->id, 'price' => 2000, 'billing_frequency' => 'monthly']);
    $weeklyPlan = Plan::factory()->create(['business_id' => $business->id, 'price' => 100, 'billing_frequency' => 'weekly']);

    Subscriber::factory()->create(['business_id' => $business->id, 'plan_id' => $monthlyPlan->id, 'status' => 'active']);
    Subscriber::factory()->create(['business_id' => $business->id, 'plan_id' => $weeklyPlan->id, 'status' => 'active']);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    // 2000 + (100 * 4.33) = 2433.00
    $response->assertSee('2,433.00');
});