<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Panduan;

class PanduanAndSimulationTest extends TestCase
{
    use RefreshDatabase;

    public function test_panduan_index_and_show_renders(): void
    {
        $this->seed();

        $response = $this->get('/panduan');
        $response->assertStatus(200);
        $response->assertSee('Pusat Panduan');

        $panduan = Panduan::first();
        $showResponse = $this->get("/panduan/{$panduan->slug}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee($panduan->judul);
    }

    public function test_simulation_sandbox_renders(): void
    {
        $response = $this->get('/panduan/latihan-mandiri');
        $response->assertStatus(200);
        $response->assertSee('Mode Latihan Mandiri');
    }
}
