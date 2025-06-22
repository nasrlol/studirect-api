<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Diploma;
use App\Models\Skill;
use App\Models\Student;
use Database\Seeders\DiplomaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_students(): void
    {
        Student::factory()->count(3)->create();
        $admin = Admin::factory()->create();

        Sanctum::actingAs($admin, ['admin']);

        $response = $this->getJson('/api/students');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'study_direction',
                        'graduation_track',
                        'job_preferences',
                        'cv',
                        'profile_complete',
                        'profile_photo',
                    ]
                ]
            ]);
    }

    public function test_store_creates_student(): void
    {
        $this->seed(DiplomaSeeder::class);
        $diploma = Diploma::first();


        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'study_direction' => 'Informatica',
            'graduation_track' => $diploma ? $diploma->id : 1,
            'job_preferences' => 'Software Development',
            'cv' => 'path/to/cv.pdf',
            'profile_complete' => true,
            'profile_photo' => 'path/to/photo.jpg',
        ];

        $student = Student::factory()->create();
        $response = $this->actingAs($student)->postJson('/api/students', $data);


        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'study_direction',
                    'graduation_track',
                    'job_preferences',
                ],
                'message'
            ]);

        $this->assertDatabaseHas('students', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'study_direction' => $data['study_direction'],
            'graduation_track' => $data['graduation_track'],
            'job_preferences' => $data['job_preferences'],
        ]);

    }

    public function test_show_returns_student(): void
    {
        $student = Student::factory()->create();
        $skills = Skill::inRandomOrder()->take(2)->get();
        $student->skills()->attach($skills);

        Sanctum::actingAs($student, ['student']);
        $response = $this->getJson("/api/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $student->id,
                    'email' => $student->email,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'study_direction' => $student->study_direction,
                    'graduation_track' => $student->graduation_track,
                    'job_preferences' => $student->job_preferences,

                ]
            ]);
    }

    public function test_update_modifies_student(): void
    {
        $student = Student::factory()->create();
        $this->seed(DiplomaSeeder::class);
        $diploma = Diploma::first();

        Sanctum::actingAs($student, ['student']);

        $data = [
            'first_name' => 'Updated',
            'last_name' => 'Doe',
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'study_direction' => 'Informatica',
            'graduation_track' => $diploma ? $diploma->id : 1,
            'job_preferences' => 'Software Development',
        ];

        $response = $this->putJson("/api/students/{$student->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Student updated successfully',
            ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'first_name' => 'Updated',
            'last_name' => 'Doe',
            'email' => $data['email'],
            'study_direction' => $data['study_direction'],
            'graduation_track' => $data['graduation_track'],
            'job_preferences' => $data['job_preferences'],
        ]);
    }

    public function test_destroy_deletes_student(): void
    {
        $student = Student::factory()->create();

        Sanctum::actingAs($student, ['student']);
        $response = $this->deleteJson("/api/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Student deleted successfully',
            ]);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }
}
