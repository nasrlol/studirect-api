<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Log;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogTestApi extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_logs()
    {
        $admin = Admin::factory()->create();
        Log::factory()->count(5)->create();

        Sanctum::actingAs($admin, ['admin']);

        $response = $this->getJson('/api/logs');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_student_cannot_view_logs()
    {
        $student = Student::factory()->create();
        Sanctum::actingAs($student, ['student']);

        $response = $this->getJson('/api/logs');
        $response->assertStatus(403);
    }

    public function test_company_cannot_view_logs()
    {
        $company = Company::factory()->create();
        Sanctum::actingAs($company, ['company']);

        $response = $this->getJson('/api/logs');
        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_cannot_view_logs()
    {
        $response = $this->getJson('/api/logs');
        $response->assertStatus(401);
    }
}
