<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Log;
use App\Models\Connection;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Student;
use App\Models\Appointment;
// use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call the diploma seeder first
        $this->call(DiplomaSeeder::class);
        
        // Create skills
        $this->call(SkillSeeder::class);
        
        // Create entities
        Student::factory()->count(20)->create();
        Company::factory()->count(20)->create();
        Appointment::factory()->count(20)->create();
        Connection::factory()->count(20)->create();
        Admin::factory()->count(20)->create();
        Log::factory()->count(20)->create();
        
        // Assign random skills to students
        $skills = Skill::all();
        Student::all()->each(function ($student) use ($skills) {
            $student->skills()->attach(
                $skills->random(rand(5, 15))->pluck('id')->toArray()
            );
        });
        
        // Assign random skills to companies
        Company::all()->each(function ($company) use ($skills) {
            $company->skills()->attach(
                $skills->random(rand(5, 20))->pluck('id')->toArray()
            );
        });
    }
}
