<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ktp_hilangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_lacak', 20)->unique(); // Misal: KTP-202610-7B3F
            $table->string('nik_pemohon', 16);
            $table->string('nama_pemohon');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama')->default('Islam');
            $table->string('pekerjaan');
            $table->string('no_hp', 20);
            $table->text('alamat');
            $table->string('rt', 5);
            $table->string('rw', 5);
            
            // Detail Kehilangan
            $table->string('lokasi_kehilangan');
            $table->date('tanggal_kehilangan');
            $table->text('kronologi');
            $table->string('berkas_kk')->nullable();
            $table->string('berkas_surat_polisi')->nullable();
            
            // 4 Langkah Alur:
            // 1. diajukan (Pengajuan oleh warga)
            // 2. verifikasi_rt (Diverifikasi oleh Ketua RT setempat)
            // 3. disetujui_kades (Disetujui Kepala Desa & Nomor Surat Terbit)
            // 4. selesai (Surat Keterangan siap diambil / diunduh)
            // Atau: ditolak
            $table->enum('status', [
                'diajukan',
                'verifikasi_rt',
                'disetujui_kades',
                'selesai',
                'ditolak'
            ])->default('diajukan');

            $table->text('catatan_rt')->nullable();
            $table->foreignId('verified_rt_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_rt_at')->nullable();

            $table->text('catatan_kades')->nullable();
            $table->foreignId('approved_kades_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_kades_at')->nullable();

            $table->string('no_surat_keterangan')->nullable();
            $table->date('tgl_surat_keterangan')->nullable();

            // Etika Profesi: Persetujuan Warga terhadap pemrosesan data identitas
            $table->boolean('opt_in_persetujuan')->default(true);

            $table->timestamps();

            $table->index('kode_lacak');
            $table->index('status');
            $table->index(['rt', 'rw']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ktp_hilangs');
    }
};
