<?php

use App\Models\Business;
use App\Models\Plan;
use App\Models\User;

it('prevents a user from editing another business plan', function () {
    $businessA = Business::factory()->create();
    $businessB = Business::factory()->create();

    $userA = User::factory()->create(['business_id' => $businessA->id]);
    $planB = Plan::factory()->create(['business_id' => $businessB->id]);

    $response = $this->actingAs($userA)->get(route('plans.edit', $planB));

    $response->assertForbidden();
});