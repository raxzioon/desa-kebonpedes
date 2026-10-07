<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\Stunting;
use App\Models\PindahWarga;
use App\Models\KematianWarga;

class PendudukAndStuntingTest extends TestCase
{
    use RefreshDatabase;

    public function test_penduduk_list_scoped_for_rt(): void
    {
        $this->seed();
        $rt01 = User::where('email', 'rt01@kebonpedes.desa.id')->first();
        
        $response = $this->actingAs($rt01)->get('/data-penduduk');
        $response->assertStatus(200);
        $response->assertSee('Data Warga');
    }

    public function test_store_penduduk_with_opt_in(): void
    {
        $this->seed();
        $rt01 = User::where('email', 'rt01@kebonpedes.desa.id')->first();

        $response = $this->actingAs($rt01)->post('/data-penduduk/simpan', [
            'nik' => '3202149999990001',
            'no_kk' => '3202149999990001',
            'nama' => 'Warga Baru Uji',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Sukabumi',
            'tanggal_lahir' => '1995-05-15',
            'agama' => 'Islam',
            'pendidikan' => 'S1',
            'pekerjaan' => 'Wiraswasta',
            'status_pernikahan' => 'Menikah',
            'golongan_darah' => 'O',
            'rt' => '01',
            'rw' => '01',
            'alamat' => 'Jl. Baru No. 1',
            'opt_in_persetujuan' => '1',
        ]);

        $response->assertRedirect('/data-penduduk');
        $this->assertDatabaseHas('penduduks', [
            'nama' => 'Warga Baru Uji',
            'opt_in_persetujuan' => true,
        ]);
    }

    public function test_kader_can_store_stunting_checkup(): void
    {
        $this->seed();
        $kader = User::where('email', 'kader@kebonpedes.desa.id')->first();

        $response = $this->actingAs($kader)->post('/data-stunting/simpan', [
            'nama_anak' => 'Bayi Uji Coba',
            'tanggal_lahir' => '2024-01-01',
            'jenis_kelamin' => 'L',
            'nama_ibu' => 'Ibu Uji',
            'nama_ayah' => 'Ayah Uji',
            'rt' => '01',
            'rw' => '01',
            'berat_badan' => 8.5,
            'tinggi_badan' => 76.0,
            'status_gizi' => 'Gizi Baik (Normal)',
            'status_stunting' => 'Normal',
            'tanggal_pemeriksaan' => '2026-10-01',
            'posyandu_nama' => 'Posyandu Melati 1',
        ]);

        $response->assertRedirect('/data-stunting');
        $this->assertDatabaseHas('stuntings', [
            'nama_anak' => 'Bayi Uji Coba',
        ]);
    }

    public function test_kades_approve_pindah_updates_penduduk_status(): void
    {
        $this->seed();
        $kades = User::where('email', 'kades@kebonpedes.desa.id')->first();
        $pindah = PindahWarga::where('status_pengajuan', 'menunggu')->first();

        $response = $this->actingAs($kades)->post("/layanan/pindah-warga/{$pindah->id}/setujui");
        $response->assertSessionHas('success');

        $pindah->refresh();
        $this->assertEquals('disetujui', $pindah->status_pengajuan);
        $this->assertEquals('pindah', $pindah->penduduk->status_dasar);
    }
}
