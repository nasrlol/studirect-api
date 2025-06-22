<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Log;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_logs()
    {
        $admin = Admin::factory()->create();
        Log::factory()->count(5)->create();

        Sanctum::actingAs($admin, ['admin']);
        $response = $this->getJson('/api/admin/logs');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_student_logs()
    {
        $admin = Admin::factory()->create();
        $student = Student::factory()->create();

        Log::factory()->create([
            'actor' => 'Student',
            'actor_id' => $student->id,
        ]);

        Sanctum::actingAs($admin, ['admin']);
        $response = $this->getJson("/api/admin/logs/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_company_logs()
    {
        $admin = Admin::factory()->create();
        $company = Company::factory()->create();

        Log::factory()->create([
            'actor' => 'Company',
            'actor_id' => $company->id,
        ]);

        Sanctum::actingAs($admin, ['admin']);
        $response = $this->getJson("/api/admin/logs/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_get_admin_logs()
    {
        $admin = Admin::factory()->create();

        Log::factory()->create([
            'actor' => 'Admin',
            'actor_id' => $admin->id,
        ]);

        Sanctum::actingAs($admin, ['admin']);
        $response = $this->getJson("/api/admin/logs/admins/{$admin->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }
}
