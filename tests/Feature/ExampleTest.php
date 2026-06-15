<?php

use App\Models\User;

test('the application redirects to dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});

test('the dashboard returns a successful response', function () {
    $user = User::factory()->create([
        'status' => 'active',
    ]);

    $this->actingAs($user);

    $response = $this->get('/dashboard');

    $response->assertStatus(200);
});
