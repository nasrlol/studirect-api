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
        Student::factory()->count(200)->create();
        Company::factory()->count(50)->create();
        Appointment::factory()->count(100)->create();
        Connection::factory()->count(10)->create();
        Admin::factory()->count(2)->create();
        AdminLog::factory()->count(5)->create();
        // $this->call(AdminSeeder::class);
    }
}
