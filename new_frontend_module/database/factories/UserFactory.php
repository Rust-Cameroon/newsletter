<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ranking_id' => $this->faker->randomNumber(),
            'rankings' => $this->faker->text,
            'avatar' => $this->faker->imageUrl(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'date_of_birth' => $this->faker->date,
            'city' => $this->faker->city,
            'zip_code' => $this->faker->postcode,
            'address' => $this->faker->address,
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'profit_balance' => $this->faker->randomFloat(2, 0, 10000),
            'status' => $this->faker->boolean,
            'ref_id' => $this->faker->randomNumber(),
            'kyc' => $this->faker->boolean,
            'kyc_credential' => $this->faker->text,
            'google2fa_secret' => $this->faker->text,
            'two_fa' => $this->faker->boolean,
            'deposit_status' => $this->faker->boolean,
            'withdraw_status' => $this->faker->boolean,
            'transfer_status' => $this->faker->boolean,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Change 'password' to your desired default password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
