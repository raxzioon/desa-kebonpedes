<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pindah_wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduks')->cascadeOnDelete();
            $table->string('no_surat_pengantar')->unique();
            $table->text('alamat_tujuan');
            $table->string('rt_tujuan', 5)->nullable();
            $table->string('rw_tujuan', 5)->nullable();
            $table->string('desa_kelurahan_tujuan');
            $table->string('kecamatan_tujuan');
            $table->string('kabupaten_kota_tujuan');
            $table->string('provinsi_tujuan');
            $table->string('alasan_pindah')->default('Pekerjaan');
            $table->date('tanggal_pindah');
            $table->integer('jumlah_keluarga_pindah')->default(1);
            
            // Status Workflow: Menunggu Verifikasi Kades -> Disetujui -> Otomatis update status penduduk
            $table->enum('status_pengajuan', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->text('catatan_kades')->nullable();
            
            $table->foreignId('diajukan_oleh_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('disetujui_oleh_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('disetujui_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pindah_wargas');
    }
};
