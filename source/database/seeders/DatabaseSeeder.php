<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Log;
use App\Models\Connection;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Student;
use App\Models\Appointment;
// use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // roept de diplomas aan
        $this->call(DiplomaSeeder::class);
        Student::factory()->count(20)->create();
        Company::factory()->count(20)->create();
        Appointment::factory()->count(20)->create();
        Connection::factory()->count(20)->create();
        Admin::factory()->count(20)->create();
        Log::factory()->count(20)->create();
    }
}
