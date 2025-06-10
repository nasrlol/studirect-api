<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Connectie;

class ConnectieSeeder extends Seeder
{
    public function run(): void
    {
        Connectie::factory()->count(10)->create();
    }
}
