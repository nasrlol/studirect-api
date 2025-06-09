<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'password' => 'password', // dit hoeft nog niet hier hashed te worden omdat ik de setAttribute functie ga maken die het wel gaat het hashen voor ons
            'plan_type' => $this->faker->randomElement(['Basic','Standard', 'Premium']),
            'description' => $this->faker->paragraph(2),
            'job_types' => $this->faker->randomElement(['Stagair','Fulltime','Studentenjob']),
            'job_domain' => $this->faker->randomElement(['Artificial Intelligence', 'Software Development', 'Business Intelligence', 'Netwerken', 'Robotics']),
            'booth_location' => $this->faker->randomElement([
                'A12', 'B5', 'C7', 'D3', 'E10']),
            'photo' => $this->faker->url(),
            'speeddate_duration' => $this->faker->numberBetween(1,30)
        ];
    }
}
