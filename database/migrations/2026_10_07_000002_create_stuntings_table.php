<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stuntings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak');
            $table->string('nik_anak', 16)->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nama_ibu');
            $table->string('nama_ayah');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->decimal('berat_badan', 5, 2); // dalam kg
            $table->decimal('tinggi_badan', 5, 2); // dalam cm
            $table->decimal('lingkar_kepala', 5, 2)->nullable(); // dalam cm
            
            // Klasifikasi Kesehatan & Gizi
            $table->enum('status_gizi', ['Gizi Buruk', 'Gizi Kurang', 'Gizi Baik (Normal)', 'Risiko Gizi Lebih', 'Gizi Lebih'])->default('Gizi Baik (Normal)');
            $table->enum('status_stunting', ['Sangat Pendek (Severely Stunted)', 'Pendek (Stunted)', 'Normal', 'Tinggi'])->default('Normal');
            
            $table->date('tanggal_pemeriksaan');
            $table->string('posyandu_nama')->default('Posyandu Melati 1');
            $table->text('catatan_kader')->nullable();
            $table->text('intervensi_diberikan')->nullable(); // contoh: Biskuit PMT, Taburia, Vitamin A
            $table->foreignId('kader_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['rt', 'rw']);
            $table->index('status_stunting');
            $table->index('tanggal_pemeriksaan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stuntings');
    }
};
