<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\KtpHilang;
use App\Models\Umkm;
use App\Models\Kegiatan;

class KtpUmkmKegiatanTest extends TestCase
{
    use RefreshDatabase;

    public function test_citizen_can_submit_ktp_hilang_and_track(): void
    {
        $this->seed();

        $response = $this->post('/ktp-hilang/simpan', [
            'nama_pemohon' => 'Warga Penguji',
            'nik_pemohon' => '3202148888880001',
            'tempat_lahir' => 'Sukabumi',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'no_hp' => '081234567890',
            'alamat' => 'Kp. Kebonpedes No. 99',
            'rt' => '01',
            'rw' => '01',
            'lokasi_kehilangan' => 'Pasar Tradisional',
            'tanggal_kehilangan' => '2026-10-01',
            'kronologi' => 'Dompet terjatuh di jalan',
            'opt_in_persetujuan' => '1',
        ]);

        $this->assertDatabaseHas('ktp_hilangs', [
            'nama_pemohon' => 'Warga Penguji',
        ]);

        $ktp = KtpHilang::where('nama_pemohon', 'Warga Penguji')->first();
        $response->assertRedirect("/ktp-hilang/lacak?kode_lacak={$ktp->kode_lacak}");

        // Lacak status
        $lacakResponse = $this->get("/ktp-hilang/lacak?kode_lacak={$ktp->kode_lacak}");
        $lacakResponse->assertStatus(200);
        $lacakResponse->assertSee($ktp->kode_lacak);
    }

    public function test_umkm_catalog_renders(): void
    {
        $this->seed();

        $response = $this->get('/pasar-umkm');
        $response->assertStatus(200);
        $response->assertSee('Etalase Produk UMKM');

        $umkm = Umkm::first();
        $detailResponse = $this->get("/pasar-umkm/{$umkm->id}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($umkm->nama_produk);
    }

    public function test_volunteer_registration_works(): void
    {
        $this->seed();
        $kegiatan = Kegiatan::first();

        $response = $this->post("/gotong-royong/{$kegiatan->id}/daftar-relawan", [
            'nama_relawan' => 'Relawan Uji Coba',
            'no_wa' => '081299990000',
            'rt' => '01',
            'rw' => '01',
            'pesan_dukungan' => 'Siap membantu!',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('relawan_kegiatans', [
            'nama_relawan' => 'Relawan Uji Coba',
            'kegiatan_id' => $kegiatan->id,
        ]);
    }

    public function test_printable_letter_renders(): void
    {
        $this->seed();
        $ktp = KtpHilang::where('status', 'selesai')->first();

        $response = $this->get("/ktp-hilang/cetak/{$ktp->id}");
        $response->assertStatus(200);
        $response->assertSee('SURAT KETERANGAN KEHILANGAN KTP');
    }
}
