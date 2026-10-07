<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori'); // Kerja Bakti Lingkungan, Posyandu & Balita Sehat, Santunan Warga & Yatim, Rembug Warga, Pelatihan UMKM
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->date('tanggal_kegiatan');
            $table->string('jam_kegiatan', 30)->default('08.00 WIB - Selesai');
            $table->integer('kuota_relawan')->default(15);
            $table->string('kontak_pj');
            $table->string('no_wa_pj', 20);
            $table->string('foto')->nullable();
            $table->enum('status', ['Akan Datang', 'Berlangsung', 'Selesai'])->default('Akan Datang');
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('kategori');
            $table->index('status');
            $table->index('tanggal_kegiatan');
        });

        Schema::create('relawan_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->cascadeOnDelete();
            $table->string('nama_relawan');
            $table->string('no_wa', 20);
            $table->string('rt', 5)->default('01');
            $table->string('rw', 5)->default('01');
            $table->text('pesan_dukungan')->nullable();
            $table->enum('status_kehadiran', ['Terdaftar', 'Hadir', 'Berhalangan'])->default('Terdaftar');
            $table->timestamps();

            $table->index('kegiatan_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('relawan_kegiatans');
        Schema::dropIfExists('kegiatans');
    }
};
