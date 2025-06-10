<?php

namespace Database\Factories;

use App\Models\Connection;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionFactory extends Factory
{
    protected $model = Connection::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'company_id' => Company::factory(),
            'status' => $this->faker->boolean(),
        ];
    }
}
