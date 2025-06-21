<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_admins()
    {
        $admin = Admin::factory()->create();
        Sanctum::actingAs($admin, ['admin']);

        $response = $this->getJson('/api/admins');
        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_store_creates_admin()
    {
        $admin = Admin::factory()->create();
        Sanctum::actingAs($admin, ['admin']);

        $data = [
            'email' => 'ikbenstinkie@gamail.com',
            'password' => 'blablablawachtwoord',
            'profile_photo' => 'pfp.jpg',
        ];

        $response = $this->postJson('/api/admins', $data);
        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'email']]);
        $this->assertDatabaseHas('admins', ['email' => $data['email']]);
    }

    public function test_show_returns_admin()
    {
        $admin = Admin::factory()->create();
        Sanctum::actingAs($admin, ['admin']);

        $response = $this->getJson("/api/admins/{$admin->id}");
        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $admin->id]]);
    }

    public function test_update_modifies_admin()
    {
        $admin = Admin::factory()->create();
        Sanctum::actingAs($admin, ['admin']);

        $data = [
            'email' => 'aangepast@gamail.com',
            'password' => 'nogeenwachtwoord',
            'profile_photo' => 'updated.jpg'
        ];

        $response = $this->putJson("/api/admins/{$admin->id}", $data);
        $response->assertStatus(200)
            ->assertJson(['data' => ['email' => $data['email']]]);
        $this->assertDatabaseHas('admins', ['email' => $data['email']]);
    }

    public function test_destroy_deletes_admin()
    {
        $admin = Admin::factory()->create();
        Sanctum::actingAs($admin, ['admin']);

        $response = $this->deleteJson("/api/admins/{$admin->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('admins', ['id' => $admin->id]);
    }
}
