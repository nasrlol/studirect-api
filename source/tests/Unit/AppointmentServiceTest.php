<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Student;
use App\Services\AppointmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AppointmentService $service;

    public function test_overlap_returns_true_when_overlap_exists()
    {
        Appointment::factory()->create([
            'student_id' => $this->student->id,
            'company_id' => $this->company->id,
            'time_start' => '10:00',
            'time_end' => '11:00',
        ]);

        $data = [
            'student_id' => $this->student->id,
            'company_id' => $this->company->id,
            'time_start' => '10:30',
            'time_end' => '11:30',
        ];

        $this->assertTrue($this->service->appointmentTimeOverlap($data));
    }

    public function test_overlap_returns_false_when_no_overlap()
    {

        Appointment::factory()->create([
            'student_id' => $this->student->id,
            'company_id' => $this->company->id,
            'time_start' => '10:00',
            'time_end' => '11:00',
        ]);

        $data = [
            'student_id' => $this->student->id,
            'company_id' => $this->company->id,
            'time_start' => '11:30',
            'time_end' => '12:30',
        ];

        $this->assertFalse($this->service->appointmentTimeOverlap($data));
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AppointmentService();

        $this->student = Student::factory()->create();
        $this->company = Company::factory()->create();
    }


}
