<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\Student;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Student::factory()->count(10)->create();
        Company::factory()->count(5)->create();

    }
}
