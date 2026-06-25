<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Full_Name' => fake()->name(),
            'Email' => fake()->unique()->safeEmail(),
            'Phone_Number' => fake()->phoneNumber(),
            'Identity_Type' => 'CNIC',
            'Identity_Number' => fake()->numerify('#####-#######-#'),
            'Password' => static::$password ??= Hash::make('password'),
            'Registration_Date' => now()->toDateString(),
            'Status' => 'Active',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            // No-op or keep empty, as email_verified_at does not exist in schema
        ]);
    }
}
