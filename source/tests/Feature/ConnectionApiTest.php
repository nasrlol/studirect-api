<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Connection;
use App\Models\Student;
use App\Policies\ConnectionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ConnectionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_connections()
    {
        Connection::factory()->count(2)->create();
        $admin = Admin::factory()->create();
        Sanctum::actingAs($admin, ['admin']);

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

        Sanctum::actingAs($student, ['student']);
        $response = $this->postJson('/api/connections', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id']]);
    }

    public function test_show_returns_connection()
    {
        $student = Student::factory()->create();
        $connection = Connection::factory()->create(['student_id' => $student->id]);

        Sanctum::actingAs($student, ['student']);
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
        ];

        $student = Student::find($connection->student_id);
        Sanctum::actingAs($student, ['student']);


        $response = $this->patchJson("/api/connections/{$connection->id}", $data);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'student_id', 'company_id', 'status']]);
    }

    public function test_destroy_deletes_connection()
    {
        $connection = Connection::factory()->create();

        $student = Student::find($connection->student_id);
        Sanctum::actingAs($student, ['student']);


        $response = $this->deleteJson("/api/connections/{$connection->id}");
        Sanctum::actingAs($student, ['student']);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('connections', ['id' => $connection->id]);
    }

    public function test_student_can_view_own_connections()
    {
        $student = Student::factory()->create();
        $otherStudent = Student::factory()->create();
        $company = Company::factory()->create();

        // 2 connections for current student, 1 for someone else
        Connection::factory()->count(2)->create(['student_id' => $student->id, 'company_id' => $company->id]);
        Connection::factory()->create(['student_id' => $otherStudent->id, 'company_id' => $company->id]);

        Sanctum::actingAs($student, ['student']);

        $response = $this->getJson("/api/connections/student/{$student->id}");
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_student_cannot_view_connections_of_other_student()
    {
        $student = Student::factory()->create();
        $otherStudent = Student::factory()->create();
        $company = Company::factory()->create();

        Connection::factory()->create(['student_id' => $otherStudent->id, 'company_id' => $company->id]);

        Sanctum::actingAs($student, ['student']);

        $response = $this->getJson("/api/connections/student/{$otherStudent->id}");
        $response->assertStatus(403);
    }

    public function test_company_can_view_own_connections()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();
        $otherCompany = Company::factory()->create();

        Connection::factory()->count(2)->create(['student_id' => $student->id, 'company_id' => $company->id]);
        Connection::factory()->create(['student_id' => $student->id, 'company_id' => $otherCompany->id]);

        Sanctum::actingAs($company, ['company']);

        $response = $this->getJson("/api/connections/company/{$company->id}");
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }

    public function test_company_cannot_view_connections_of_other_company()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();
        $otherCompany = Company::factory()->create();

        Connection::factory()->create(['student_id' => $student->id, 'company_id' => $otherCompany->id]);

        Sanctum::actingAs($company, ['company']);

        $response = $this->getJson("/api/connections/company/{$otherCompany->id}");
        $response->assertStatus(403);
    }

    public function test_admin_can_view_connections_of_any_student_or_company()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();
        $admin = Admin::factory()->create();

        Connection::factory()->count(2)->create(['student_id' => $student->id, 'company_id' => $company->id]);

        Sanctum::actingAs($admin, ['admin']);

        $resStudent = $this->getJson("/api/connections/student/{$student->id}");
        $resCompany = $this->getJson("/api/connections/company/{$company->id}");

        $resStudent->assertStatus(200)->assertJsonCount(2, 'data');
        $resCompany->assertStatus(200)->assertJsonCount(2, 'data');
    }

}
