<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Company;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        // Kies random bestaande actor
        $actorClass = $this->faker->randomElement([
            Admin::class,
            Student::class,
            Company::class
        ]);

        $actor = $actorClass::inRandomOrder()->first();

        // Kies random bestaande target
        $targetClass = $this->faker->randomElement([
            Admin::class,
            Student::class,
            Company::class
        ]);

        $target = $targetClass::inRandomOrder()->first();

        return [
            'actor_type'  => $actorClass,
            'actor_id'    => $actor ? $actor->id : null,
            'action'      => $this->faker->randomElement([
                'create', 'delete', 'update', 'read', 'message_sent', 'appointment_created'
            ]),
            'target_type' => $targetClass,
            'target_id'   => $target ? $target->id : null,
            'severity'    => $this->faker->randomElement(['low', 'medium', 'high', 'critical']),
            'created_at'  => now(), // BELANGRIJK → timestamps invullen
        ];
    }
}
