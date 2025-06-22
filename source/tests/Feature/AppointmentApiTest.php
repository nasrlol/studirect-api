<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;


    public function test_index_returns_appointments()
    {
        // Getting all the appointments is something only admins can do
        $admin = Admin::factory()->create();
        Appointment::factory()->count(10)->create();

        $response = $this->actingAs($admin)->getJson("/api/appointments");

        $response->assertStatus(200);
    }

    public function test_index_should_return_false_for_non_admin()
    {
        // Students and companies should not be able to access the index endpoint
        $company = Company::factory()->create();
        $response = $this->actingAs($company)->getJson('/api/appointments');
        $response->assertStatus(403)
            ->assertJsonFragment(['message' => 'This action is unauthorized.']);
    }

    public function test_show_returns_appointment()
    {
        $student = Student::factory()->create();
        $appointment = Appointment::factory()->create();

        $response = $this->actingAs($student)->getJson("/api/appointments/{$appointment->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $appointment->id]);


    }

    public function test_store_creates_appointment()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();

        $data = [
            'student_id' => $student->id,
            'company_id' => $company->id,
            'time_start' => "15:00",
            'time_end' => "15:30"
        ];

        $response = $this->actingAs($student)->postJson('/api/appointments', $data);
        $response->assertStatus(201)
            ->assertJsonFragment(['student_id' => $student->id]);
        $this->assertDatabaseHas('appointments', $data);
    }

    public function test_store_prevents_double_booking()
    {
        $student = Student::factory()->create();
        $company = Company::factory()->create();
        $time_start = '18:00';
        $time_end = '18:30';

        Appointment::factory()->create([
            'student_id' => $student->id,
            'company_id' => $company->id,
            'time_start' => "18:00",
            'time_end' => "18:30"
        ]);

        $response = $this->actingAs($student)->postJson('/api/appointments', [
            'student_id' => $student->id,
            'company_id' => $company->id,
            'time_start' => $time_start,
            'time_end' => $time_end
        ]);

        $response->assertStatus(400)
            ->assertJsonFragment(['message' => 'That time slot is already being used']);
    }


    public function test_show_returns_404_for_missing()
    {
        $student = Student::factory()->create();
        $response = $this->actingAs($student)->getJson('/api/appointments/9999');
        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Appointment not found']);
    }

    public function test_update_changes_time_student()
    {
        $student = Student::factory()->create();
        $appointment = Appointment::factory()->create([
            'student_id' => $student->id,
            'time_start' => '12:00',
            'time_end' => '12:30',
        ]);

        $response = $this->actingAs($student)->putJson("/api/appointments/{$appointment->id}", [
            'time_start' => '13:00',
            'time_end' => '13:30',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['time_start' => '13:00', 'time_end' => '13:30']);
        $this->assertDatabaseHas('appointments', [
            'time_start' => '13:00',
            'time_end' => '13:30',
        ]);
    }

    public function test_update_changes_time_company()
    {
        $company = Company::factory()->create();
        $appointment = Appointment::factory()->create([
            'company_id' => $company->id,
            'time_start' => '12:00',
            'time_end' => '12:30',
        ]);

        $response = $this->actingAs($company)->putJson("/api/appointments/{$appointment->id}", [
            'time_start' => '13:00',
            'time_end' => '13:30',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['time_start' => '13:00', 'time_end' => '13:30']);

        $this->assertDatabaseHas('appointments', [
            'time_start' => '13:00',
            'time_end' => '13:30',
        ]);
    }

    public function test_update_changes_time_admin()
    {
        $admin = Admin::factory()->create();

        $appointment = Appointment::factory()->create([
            'time_start' => '12:00',
            'time_end' => '12:30',
        ]);
        $response = $this->actingAs($admin)->putJson("/api/appointments/{$appointment->id}", [
            'time_start' => '13:00',
            'time_end' => '13:30',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['time_start' => '13:00', 'time_end' => '13:30']);
        $this->assertDatabaseHas('appointments', [
            'time_start' => '13:00',
            'time_end' => '13:30',
        ]);
    }


    public function test_destroy_deletes_appointment_admin()
    {
        $admin = Admin::factory()->create();
        $appointment = Appointment::factory()->create();
        $response = $this->actingAs($admin)->deleteJson("/api/appointments/{$appointment->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Appointment deleted successfully']);
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    public function test_destroy_deletes_appointment_student()
    {
        $student = Student::factory()->create();

        $appointment = Appointment::factory()->create([
            'student_id' => $student->id,
        ]);

        $response = $this->actingAs($student)->deleteJson("/api/appointments/{$appointment->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Appointment deleted successfully']);
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }


    public function test_destroy_returns_404_for_missing()
    {
        $student = Student::factory()->create();
        $response = $this->actingAs($student)->deleteJson('/api/appointments/9999');
        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Appointment not found']);
    }
}
