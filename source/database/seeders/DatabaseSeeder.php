<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminLog;
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
        Student::factory()->count(30)->create();
        Company::factory()->count(30)->create();
        Appointment::factory()->count(30)->create();
        Connection::factory()->count(10)->create();
        Admin::factory()->count(5)->create();
        AdminLog::factory()->count(5)->create();
        // $this->call(AdminSeeder::class);
    }
}
