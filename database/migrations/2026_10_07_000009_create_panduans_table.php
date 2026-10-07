<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panduans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori'); // Panduan Penggunaan, Glosarium Desa, SOP Layanan, Fitur Aksesibilitas
            $table->string('icon')->default('book-open');
            $table->text('ringkasan');
            $table->longText('konten');
            $table->string('target_peran')->default('Semua'); // Semua, Ketua RT/RW, Kader Posyandu, Kepala Desa, Warga
            $table->integer('urutan')->default(1);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->index('kategori');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panduans');
    }
};
