<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kematian_wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->constrained('penduduks')->cascadeOnDelete();
            $table->date('tanggal_kematian');
            $table->string('waktu_kematian', 10)->nullable();
            $table->string('tempat_kematian')->default('Rumah Duka');
            $table->string('sebab_kematian')->default('Sakit / Menua');
            $table->string('nama_pelapor');
            $table->string('hubungan_pelapor')->default('Keluarga / Ahli Waris');
            
            // Workflow Status: menunggu -> disetujui -> update penduduk status_dasar=meninggal
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
        Schema::dropIfExists('kematian_wargas');
    }
};
