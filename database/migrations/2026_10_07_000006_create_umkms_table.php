<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('nama_pemilik');
            $table->string('nomor_wa', 20); // 628xxx format
            $table->string('kategori'); // Makanan & Minuman, Kerajinan, Pertanian, Jasa Kreatif, Pangan Lokal
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2)->default(0);
            $table->string('satuan')->default('Pcs'); // Pcs, Kg, Botol, Porsi, Box
            $table->string('lokasi_pasar')->default('Pasar Tradisional Kebonpedes');
            $table->string('foto')->nullable();
            $table->string('rt', 5)->default('01');
            $table->string('rw', 5)->default('01');
            $table->boolean('is_tersedia_di_pasar')->default(true);
            $table->boolean('is_aktif')->default(true);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('kategori');
            $table->index('is_aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
