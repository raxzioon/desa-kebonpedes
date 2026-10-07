<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama')->default('Islam');
            $table->string('pendidikan')->default('SMA/Sederajat');
            $table->string('pekerjaan')->default('Wiraswasta');
            $table->string('status_pernikahan')->default('Belum Menikah');
            $table->string('golongan_darah', 5)->default('Tidak Tahu');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->text('alamat');
            $table->enum('status_dasar', ['hidup', 'meninggal', 'pindah'])->default('hidup');
            
            // Aspek Etika Profesi & PDP: Opt-in eksplisit pencatatan data warga
            $table->boolean('opt_in_persetujuan')->default(true);
            $table->timestamp('opt_in_at')->nullable();
            
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['rt', 'rw']);
            $table->index('status_dasar');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
