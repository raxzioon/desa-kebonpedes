@extends('layouts.app')

@section('title', 'Catat Pemeriksaan Balita - ' . config('desa.nama_desa'))
@section('page_title', 'Catat Pemeriksaan Balita')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('stunting.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Data Balita
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Pencatatan Penimbangan & Status Gizi Balita
        </h1>
        <p class="text-sm text-slate-600">
            Kader Posyandu memasukkan hasil penimbangan BB, pengukuran TB, dan status gizi balita.
        </p>
    </div>

    <form method="POST" action="{{ route('stunting.store') }}" class="space-y-8">
        @csrf

        <!-- INFORMASI BALITA & ORANG TUA -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-sm font-black">1</span>
                <span>Data Anak & Orang Tua</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="nama_anak" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nama Lengkap Balita: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_anak" id="nama_anak" value="{{ old('nama_anak') }}" required placeholder="Contoh: Muhammad Alif Pratama" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold focus:border-emerald-600">
                </div>

                <div>
                    <label for="nik_anak" class="block font-bold text-slate-800 text-base mb-1.5">
                        NIK Anak (Jika Ada / KIA):
                    </label>
                    <input type="text" name="nik_anak" id="nik_anak" value="{{ old('nik_anak') }}" maxlength="16" placeholder="Opsional (16 digit)" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-mono">
                </div>

                <div>
                    <label for="tanggal_lahir" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tanggal Lahir: <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">
                        Jenis Kelamin: <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex-1 btn-touch px-4 py-3 rounded-2xl border-2 border-slate-300 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50 cursor-pointer text-center font-bold">
                            <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'checked' : '' }} class="mr-2 text-emerald-600"> Laki-laki
                        </label>
                        <label class="flex-1 btn-touch px-4 py-3 rounded-2xl border-2 border-slate-300 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50 cursor-pointer text-center font-bold">
                            <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} class="mr-2 text-emerald-600"> Perempuan
                        </label>
                    </div>
                </div>

                <div>
                    <label for="nama_ibu" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nama Ibu Kandung: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}" required placeholder="Contoh: Ibu Kokom" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="nama_ayah" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nama Ayah: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah') }}" required placeholder="Contoh: Bpk Ahmad" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="rt" class="block font-bold text-slate-800 text-base mb-1.5">RT Domisili:</label>
                    <select name="rt" id="rt" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="01">RT 01</option>
                        <option value="02">RT 02</option>
                        <option value="03">RT 03</option>
                    </select>
                </div>

                <div>
                    <label for="rw" class="block font-bold text-slate-800 text-base mb-1.5">RW Domisili:</label>
                    <select name="rw" id="rw" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="01">RW 01</option>
                        <option value="02">RW 02</option>
                        <option value="03">RW 03</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- PENGUKURAN & STATUS GIZI -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black">2</span>
                <span>Hasil Pengukuran Posyandu</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                <!-- Berat Badan -->
                <div>
                    <label for="berat_badan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Berat Badan (kg): <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}" required placeholder="Contoh: 9.5" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold text-emerald-800">
                </div>

                <!-- Tinggi Badan -->
                <div>
                    <label for="tinggi_badan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tinggi / Panjang Badan (cm): <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan') }}" required placeholder="Contoh: 78.5" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold text-emerald-800">
                </div>

                <!-- Lingkar Kepala -->
                <div>
                    <label for="lingkar_kepala" class="block font-bold text-slate-800 text-base mb-1.5">
                        Lingkar Kepala (cm):
                    </label>
                    <input type="number" step="0.01" name="lingkar_kepala" id="lingkar_kepala" value="{{ old('lingkar_kepala') }}" placeholder="Contoh: 45.0" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Status Gizi -->
                <div>
                    <label for="status_gizi" class="block font-bold text-slate-800 text-base mb-1.5">
                        Status Gizi (BB/U): <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_gizi" id="status_gizi" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold">
                        <option value="Gizi Baik (Normal)">Gizi Baik (Normal)</option>
                        <option value="Gizi Kurang">Gizi Kurang</option>
                        <option value="Gizi Buruk">Gizi Buruk</option>
                        <option value="Risiko Gizi Lebih">Risiko Gizi Lebih</option>
                        <option value="Gizi Lebih">Gizi Lebih</option>
                    </select>
                </div>

                <!-- Status Stunting -->
                <div>
                    <label for="status_stunting" class="block font-bold text-slate-800 text-base mb-1.5">
                        Status Stunting (TB/U): <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_stunting" id="status_stunting" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold text-emerald-900">
                        <option value="Normal">Normal (Tumbuh Sehat)</option>
                        <option value="Pendek (Stunted)">Pendek (Stunted - Perlu PMT)</option>
                        <option value="Sangat Pendek (Severely Stunted)">Sangat Pendek (Severely Stunted - Rujukan)</option>
                        <option value="Tinggi">Tinggi</option>
                    </select>
                </div>

                <!-- Posyandu -->
                <div>
                    <label for="posyandu_nama" class="block font-bold text-slate-800 text-base mb-1.5">Nama Posyandu:</label>
                    <select name="posyandu_nama" id="posyandu_nama" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-semibold">
                        <option value="Posyandu Melati 1 (RT 01)">Posyandu Melati 1 (RT 01)</option>
                        <option value="Posyandu Mawar 2 (RT 02)">Posyandu Mawar 2 (RT 02)</option>
                        <option value="Posyandu Kenanga 3 (RT 03)">Posyandu Kenanga 3 (RT 03)</option>
                        <option value="Posyandu Anggrek 1 (RW 02)">Posyandu Anggrek 1 (RW 02)</option>
                    </select>
                </div>

                <!-- Tanggal Cek -->
                <div>
                    <label for="tanggal_pemeriksaan" class="block font-bold text-slate-800 text-base mb-1.5">Tanggal Pemeriksaan:</label>
                    <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <!-- Intervensi & PMT -->
                <div class="sm:col-span-2">
                    <label for="intervensi_diberikan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Intervensi & PMT (Pemberian Makanan Tambahan):
                    </label>
                    <input type="text" name="intervensi_diberikan" id="intervensi_diberikan" value="{{ old('intervensi_diberikan', 'Pemberian Biskuit PMT, Vitamin A, dan Edukasi Gizi') }}" placeholder="Contoh: PMT Biskuit Balita + Telur Rebus harian, Taburia" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <!-- Catatan Kader -->
                <div class="sm:col-span-2">
                    <label for="catatan_kader" class="block font-bold text-slate-800 text-base mb-1.5">Catatan Tambahan Kader:</label>
                    <textarea name="catatan_kader" id="catatan_kader" rows="2" placeholder="Catatan nafsu makan, imunisasi, atau saran bidan..." class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">{{ old('catatan_kader') }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('stunting.index') }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl">
                💾 Simpan Hasil Pemeriksaan
            </button>
        </div>
    </form>
</div>
@endsection
