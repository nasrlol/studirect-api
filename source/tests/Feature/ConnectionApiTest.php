<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Connection;
use App\Models\Student;
use App\Services\ConnectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConnectionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_connections()
    {
        Connection::factory()->count(2)->create();

        $response = $this->getJson('/api/connections');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['id', 'student_id', 'company_id', 'status', 'skill_match_percentage']
                ]
            ]);
    }

    public function test_store_creates_connection()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();

        $data = [
            'student_id' => $student->id,
            'company_id' => $company->id,
            'status' => true,
            'skill_match_percentage' => ConnectionService::calculateSkillMatchPercentage($student->id, $company->id)
        ];

        $response = $this->postJson('/api/connections', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id']]);
    }

    public function test_show_returns_connection()
    {
        $connection = Connection::factory()->create();

        $response = $this->getJson("/api/connections/{$connection->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $connection->id,
                    'student_id' => $connection->student_id,
                    'company_id' => $connection->company_id,
                    'status' => $connection->status,
                    'skill_match_percentage' => $connection->skill_match_percentage,
                ]
            ]);
    }

    public function test_update_modifies_connection()
    {
        $connection = Connection::factory()->create();

        $data = [
            'student_id' => $connection->student_id,
            'company_id' => $connection->company_id,
            'status' => false,
            'skill_match_percentage' => 75.0
        ];

        $response = $this->patchJson("/api/connections/{$connection->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'student_id', 'company_id', 'status', 'skill_match_percentage']]);
    }

    public function test_destroy_deletes_connection()
    {
        $connection = Connection::factory()->create();

        $response = $this->deleteJson("/api/connections/{$connection->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('connections', ['id' => $connection->id]);
    }
}
