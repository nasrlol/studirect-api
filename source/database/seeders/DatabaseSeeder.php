<?php

namespace Database\Seeders;

use App\Models\AdminLog;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Student;
use App\Models\Appointment;
// use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Student::factory()->count(200)->create();
        Company::factory()->count(50)->create();
        Appointment::factory()->count(100)->create();
        ConnectieSeeder::factory()->count(10)->create();
        AdminLog::factory()->count(5)->create();
        // $this->call(AdminSeeder::class);
    }
}
