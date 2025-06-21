<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Skill;
use App\Models\Student;
use Database\Seeders\SkillSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_skills()
    {
        $this->seed(SkillSeeder::class);
        $response = $this->getJson('/api/skills');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }


    public function test_attach_skills_to_student_successfully()
    {
        $this->seed(SkillSeeder::class);
        $student = Student::factory()->create();
        $skills = Skill::inRandomOrder()->take(3)->get();

        $payload = ['skill_ids' => $skills->pluck('id')->toArray()];

        $response = $this->postJson("/api/students/{$student->id}/skills", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Skills attached successfully']);

        $this->assertDatabaseHas('skill_student', [
            'student_id' => $student->id,
            'skill_id' => $skills->first()->id,
        ]);
    }

    public function test_attach_skills_to_nonexistent_student_returns_404()
    {
        $this->seed(SkillSeeder::class);
        $skills = Skill::inRandomOrder()->take(3)->get();
        $payload = ['skill_ids' => $skills->pluck('id')->toArray()];

        $response = $this->postJson('/api/students/999/skills', $payload);

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Student not found']);
    }

    public function test_attach_skills_with_invalid_skill_ids_returns_validation_error()
    {
        $student = Student::factory()->create();
        $payload = ['skill_ids' => [999, 1000]];

        $response = $this->postJson("/api/students/{$student->id}/skills", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['skill_ids.0', 'skill_ids.1']);
    }

    public function test_attach_skills_without_skill_ids_returns_validation_error()
    {
        $student = Student::factory()->create();
        $payload = [];

        $response = $this->postJson("/api/students/{$student->id}/skills", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['skill_ids']);
    }


    public function test_show_skill()
    {
        $this->seed(SkillSeeder::class);
        $skill = Skill::inRandomOrder()->first();

        $response = $this->getJson("/api/skills/{$skill->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $skill->name]);
    }

    public function test_calculatesSkillMatchPercentageSuccessfully(): void
    {
        // Seed skills
        $this->seed(SkillSeeder::class);

        // Get some random skills
        $skills = Skill::inRandomOrder()->take(3)->get();
        $skill1 = $skills[0];
        $skill2 = $skills[1];
        $skill3 = $skills[2];

        $student = Student::factory()->create();
        $student->skills()->attach([$skill1->id, $skill2->id]);

        $company = Company::factory()->create();
        $company->skills()->attach([$skill2->id, $skill3->id]);

        $response = $this->getJson("/api/match/{$student->id}/{$company->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'student_id',
                    'company_id',
                    'match_percentage'
                ]
            ]);
    }


    public function test_returnsNotFoundWhenStudentOrCompanyDoesNotExist(): void
    {
        $studentId = 999;
        $companyId = 888;

        $response = $this->getJson("/api/match/{$studentId}/{$companyId}");

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Student or company not found'
            ]);
    }
}
