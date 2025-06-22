<?php

namespace Tests\Feature;

use App\Models\Diploma;
use Database\Seeders\DiplomaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiplomaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_diplomas()
    {
        $this->seed(DiplomaSeeder::class);

        $response = $this->getJson('/api/diplomas');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['id', 'type']
                ]
            ]);
    }

    public function test_show_returns_single_diploma()
    {
        $this->seed(DiplomaSeeder::class);
        $diploma = Diploma::first();

        $response = $this->getJson("/api/diplomas/{$diploma->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $diploma->id,
                    'type' => $diploma->type,
                ]
            ]);
    }

    public function test_show_returns_404_if_diploma_not_found()
    {
        $response = $this->getJson('/api/diplomas/999');

        $response->assertStatus(404);
    }
}
