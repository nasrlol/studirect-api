<?php

namespace Database\Factories;

use App\Models\Connectie;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectieFactory extends Factory
{
    protected $model = Connectie::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id,
            'company_id' => Company::inRandomOrder()->first()->id, 
            'type' => $this->faker->randomElement(['match', 'bericht']),
        ];
    }
}
