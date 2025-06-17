<?php

namespace Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_companies()
    {
        Company::factory()->count(2)->create();

        $response = $this->getJson('/api/companies');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_store_creates_company()
    {
        $data = [
            'name' => 'Test Company',
            'email' => 'test@company.com',
            'address' => '123 Main St',
            'password' => 'password123',
            'plan_type' => 'basic',
            'booth_location' => 'Hall A',
            'job_types' => 'Fulltime, Parttime',
            'job_domain' => 'Engineering',
            'photo' => 'test_photo.jpg',
            'speeddate_duration' => 15,
            'job_requirements' => 'Bachelor\'s degree in Engineering',
            'job_description' => 'Responsible for engineering tasks.',
            'company_description' => 'A company that specializes in engineering solutions.',
        ];

        $response = $this->postJson('/api/companies', $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'name', 'email', 'address']]);

        $this->assertDatabaseHas('companies', ['email' => $data['email']]);
    }

    public function test_show_returns_company()
    {
        $company = Company::factory()->create();

        $response = $this->getJson("/api/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $company->id]]);
    }

    public function test_update_modifies_company()
    {
        $company = Company::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@company.com',
            'address' => '456 New St',
            'password' => 'newpassword123',
            'plan_type' => 'premium',
            'booth_location' => 'Hall B',
            'job_types' => 'Engineering, Design',
            'job_domain' => 'Technology',
            'photo' => 'updated_photo.jpg',
            'speeddate_duration' => 30,
            'job_requirements' => 'Master\'s degree in Technology',
            'job_description' => 'Responsible for technology-related tasks.',
            'company_description' => 'An updated company description specializing in technology solutions.',

        ];

        $response = $this->putJson("/api/companies/{$company->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => 'Updated Name']]);

        $this->assertDatabaseHas('companies', ['id' => $company->id, 'name' => 'Updated Name']);
    }

    public function test_destroy_deletes_company()
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson("/api/companies/{$company->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }
}
