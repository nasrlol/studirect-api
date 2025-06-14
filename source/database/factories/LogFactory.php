<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'actor' => $this->faker->randomElement(['Student', 'Bedrijf']),
            'action' => $this->faker->randomElement(['create', 'delete', 'update','read']),
            'target_type' => $this->faker->randomElement(['Student', 'Admin', 'Company' ]),
            // dit eve een random id laten aanmeken maar in de toekmost een studeten id of company id
            'severity' => $this->faker->randomElement(['low', 'medium', 'high', 'Critical'])
        ];
    }
}
