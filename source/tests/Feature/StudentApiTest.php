<?php

namespace Tests\Feature;

use App\Models\Diploma;
use App\Models\Student;
use Database\Seeders\DiplomaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_students(): void
    {
        Student::factory()->count(3)->create();

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
                            'interests',
                            'job_preferences',
                        ]
                ]
            ]);
    }

    public function test_store_creates_student(): void
    {
        $this->seed(DiplomaSeeder::class); // Ensure diplomas exist
        $diploma = Diploma::first(); // or create one if needed

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'study_direction' => 'Informatica',
            'graduation_track' => $diploma ? $diploma->id : 1,
            'interests' => 'Programming, AI',
            'job_preferences' => 'Software Development',
        ];

        $response = $this->postJson('/api/students', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'study_direction',
                    'graduation_track',
                    'interests',
                    'job_preferences',
                ],
                'message'
            ]);

        $this->assertDatabaseHas('students', [
            'email' => $data['email']
        ]);
    }

    public function test_show_returns_student(): void
    {
        $student = Student::factory()->create();

        $response = $this->getJson("/api/students/{$student->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $student->id,
                    'email' => $student->email,
                ]
            ]);
    }

    public function test_update_modifies_student(): void
    {
        $student = Student::factory()->create();

        $this->seed(DiplomaSeeder::class); // Ensure diplomas exist

        $diploma = Diploma::first(); // or create one if needed

        $data = [
            'first_name' => 'Updated',
            'last_name' => 'Doe',
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'study_direction' => 'Informatica',
            'graduation_track' => $diploma ? $diploma->id : 1,
            'interests' => 'Programming, AI',
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
        ]);
    }

    public function test_destroy_deletes_student(): void
    {
        $student = Student::factory()->create();

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
