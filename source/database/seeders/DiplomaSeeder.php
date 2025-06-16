<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiplomaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diplomas')->insert([
            ['type' => 'Professional Bachelor'],
            ['type' => 'Academic Bachelor'],
            ['type' => 'Master'],
            ['type' => 'Post-graduaat'],
            ['type' => 'PhD'],
            ['type' => 'Graduaat'],
        ]);
    }
}
