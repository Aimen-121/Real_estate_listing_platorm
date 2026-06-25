<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'Full_Name' => 'Test User',
        'Email' => 'test@example.com',
        'Password' => 'password',
        'Password_confirmation' => 'password',
        'roles' => ['buyer'],
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
