<?php

use App\Models\User;

test('the root URL shows the public website', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the dashboard returns a successful response', function () {
    $user = User::factory()->create([
        'status' => 'active',
    ]);

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertStatus(200);
});
