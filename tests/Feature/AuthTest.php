<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $response = $this->get('/masuk');
        $response->assertStatus(200);
        $response->assertSee('Formulir Masuk');
    }

    public function test_demo_login_as_kades(): void
    {
        $this->seed();
        $response = $this->get('/masuk-demo/kades');
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_rt_cannot_access_audit_log(): void
    {
        $this->seed();
        $rt = User::where('role', 'rt_rw')->first();
        $response = $this->actingAs($rt)->get('/audit-log');
        $response->assertStatus(403);
    }

    public function test_kades_can_access_audit_log(): void
    {
        $this->seed();
        $kades = User::where('role', 'kades')->first();
        $response = $this->actingAs($kades)->get('/audit-log');
        $response->assertStatus(200);
    }
}
