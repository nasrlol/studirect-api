<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Diploma;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        // Fetch all diploma IDs
        $diplomaIds = Diploma::pluck('id')->toArray();

        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'study_direction' => $this->faker->randomElement(['Informatica', 'Economie', 'Talen', 'Wetenschappen']),
            // Use a random diploma ID or null if none exist
            'graduation_track' => $this->faker->optional()->randomElement($diplomaIds),
            'interests' => implode(', ', $this->faker->randomElements(['AI', 'Webdev', 'Networking', 'Cybersecurity', 'IoT'], 2)),
            'job_preferences' => $this->faker->sentence(3),
            'cv' => 'cv_' . Str::random(10) . '.pdf',
            'profile_complete' => false
        ];
    }
}
