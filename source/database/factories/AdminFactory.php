<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    public function definition(): array
    {
         return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'admin123', // standaard wachtwoord
        ];
    }
}
