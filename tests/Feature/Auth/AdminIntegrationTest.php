<?php

use App\Models\Admin;
use App\Models\User;

test('admin registration creates user and admin records', function () {
    $response = $this->post('/register', [
        'Full_Name' => 'Admin User',
        'Email' => 'admin@example.com',
        'Password' => 'password',
        'Password_confirmation' => 'password',
        'roles' => ['buyer', 'admin'],
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('Email', 'admin@example.com')->first();
    expect($user)->not->toBeNull();

    $user->load(['admin', 'buyer']);
    expect($user->isAdmin())->toBeTrue();
    expect($user->isBuyer())->toBeTrue();

    $this->assertDatabaseHas('admin', [
        'User_ID' => $user->User_ID,
    ]);
    $this->assertDatabaseHas('buyer', [
        'User_ID' => $user->User_ID,
    ]);
});

test('non-admin user is forbidden from admin routes', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('admin user can access admin routes', function () {
    $user = User::factory()->create();
    Admin::create([
        'User_ID' => $user->User_ID,
        'Admin_Role' => 'Administrator',
    ]);

    $this->actingAs($user);

    $this->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Administration Console');
});
