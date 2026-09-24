<?php

use App\Models\Business;
use App\Models\User;

it('creates a business and links the user during registration', function () {
    $response = $this->post('/register', [
        'business_name' => 'Test Gym',
        'name' => 'Jane Owner',
        'email' => 'jane@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $user = User::where('email', 'jane@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->business_id)->not->toBeNull();

    $business = Business::find($user->business_id);
    expect($business)->not->toBeNull();
    expect($business->name)->toBe('Test Gym');

    $response->assertRedirect(route('dashboard', absolute: false));
});