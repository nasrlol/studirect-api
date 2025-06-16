<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'actor' => $this->faker->randomElement(['Student', 'Company']),
            'action' => $this->faker->randomElement(['create', 'delete', 'update','read']),
            'actor_id' => Student::factory(),
            'target_type' => $this->faker->randomElement(['Student', 'Admin', 'Company' ]),
            // dit eve een random id laten aanmaken maar in de toekmost een studenten id of company id
            'severity' => $this->faker->randomElement(['normal', 'critical'])
        ];
    }
}
