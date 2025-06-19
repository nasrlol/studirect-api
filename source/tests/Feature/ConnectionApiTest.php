<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Connection;
use App\Models\Student;
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
            ->assertJsonStructure(['data' => [['id']]]);
    }

    public function test_store_creates_connection()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();

        $data = [
            'student_id' => $student->id,
            'company_id' => $company->id,
            'status' => true,
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
            ->assertJson(['data' => ['id' => $connection->id]]);
    }

    public function test_update_modifies_connection()
    {
        $connection = Connection::factory()->create();

        $data = [
            'student_id' => $connection->student_id,
            'company_id' => $connection->company_id,
            'status' => false,
        ];

        $response = $this->patchJson("/api/connections/{$connection->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id']]);
    }

    public function test_destroy_deletes_connection()
    {
        $connection = Connection::factory()->create();

        $response = $this->deleteJson("/api/connections/{$connection->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('connections', ['id' => $connection->id]);
    }
}
