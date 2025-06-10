<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
   public function definition(): array
    {
        // we moeten niet zomaar studenten_ids generen het zou liefst
        // wel bestaande moeten zijn van studenten in de database om aan te tonen dat het
        // foreign keys zijn naar studenten en bedrijven die een speed_date hebben gepland
        return [
            'student_id' => Student::factory(),
            'company_id' => Company::factory(),
            'time_slot' => $this->faker->randomElement([
                '09:00 - 09:30', '09:30 - 10:00', '10:00 - 10:30']),
        ];
    }
}
