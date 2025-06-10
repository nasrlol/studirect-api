<?php

namespace Database\Factories;

use App\Models\Connection;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectieFactory extends Factory
{
    protected $model = Connection::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(['match', 'bericht']),
        ];
    }
}
