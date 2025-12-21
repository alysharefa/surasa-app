<?php

use App\Models\User;

test('admin can access dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get('/admin');

    $response->assertOk();
});

test('regular user cannot access dashboard', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get('/admin');

    $response->assertForbidden();
});

test('guest cannot access dashboard', function () {
    $response = $this->get('/admin');

    $response->assertRedirect('/login');
});
