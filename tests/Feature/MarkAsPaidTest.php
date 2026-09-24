<?php

use App\Models\BillingCycle;
use App\Models\Subscriber;
use App\Models\User;

it('marks a billing cycle as paid and creates a matching payment', function () {
    $subscriber = Subscriber::factory()->create();
    $user = User::factory()->create(['business_id' => $subscriber->business_id]);
    $cycle = BillingCycle::factory()->create([
        'subscriber_id' => $subscriber->id,
        'amount_due' => 3000,
        'status' => 'pending',
    ]);

    $this->actingAs($user)->patch(route('billing-cycles.mark-as-paid', $cycle));

    $cycle->refresh();

    expect($cycle->status)->toBe('paid');
    expect($cycle->payments)->toHaveCount(1);
    expect((float) $cycle->payments->first()->amount)->toBe(3000.0);
});