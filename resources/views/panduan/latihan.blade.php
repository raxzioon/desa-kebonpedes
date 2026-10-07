@extends('layouts.app')

@section('title', 'Mode Latihan Mandiri (Simulasi) - ' . config('desa.nama_desa'))
@section('page_title', 'Mode Latihan Simulasi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12" x-data="latihanSimulasi()">
    <div class="mb-8">
        <a href="{{ route('panduan.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Pusat Panduan
        </a>
        <div class="flex items-center gap-2 mt-2">
            <span class="px-3.5 py-1 bg-amber-400 text-slate-950 font-black text-xs rounded-full uppercase tracking-wider">
                🎮 Ruang Simulasi Interaktif
            </span>
            <span class="px-3 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                100% Aman & Tanpa Merusak Data
            </span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Mode Latihan Mandiri (Simulasi Praktik)
        </h1>
        <p class="text-base text-slate-600 mt-1">
            Gunakan halaman ini untuk melatih aparatur baru atau mencoba fitur pengisian data. Apapun yang Anda ketik di sini bersifat simulasi lokal dan <strong>TIDAK AKAN</strong> mengubah data asli desa.
        </p>
    </div>

    <!-- Pilihan Simulasi -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <button type="button" @click="mode = 'ktp'" :class="mode === 'ktp' ? 'bg-emerald-700 text-white shadow-lg border-emerald-800' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50'" class="btn-touch p-5 rounded-3xl border-2 font-black text-base transition text-left flex items-center gap-3">
            <span class="text-3xl">🆔</span>
            <div>
                <div>Latihan 1: Pengajuan KTP Hilang</div>
                <p class="text-xs opacity-80 font-normal">Coba buat permohonan dan lihat alur kode lacak</p>
            </div>
        </button>

        <button type="button" @click="mode = 'gizi'" :class="mode === 'gizi' ? 'bg-amber-600 text-white shadow-lg border-amber-700' : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50'" class="btn-touch p-5 rounded-3xl border-2 font-black text-base transition text-left flex items-center gap-3">
            <span class="text-3xl">👶</span>
            <div>
                <div>Latihan 2: Ukur Gizi & Balita</div>
                <p class="text-xs opacity-80 font-normal">Simulasi kalkulator stunting otomatis</p>
            </div>
        </button>
    </div>

    <!-- 1. SIMULASI KTP HILANG -->
    <div x-show="mode === 'ktp'" x-cloak class="bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-md space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="text-xl font-black text-slate-900">Simulasi Pengajuan Surat KTP</h3>
            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full">Mode Praktik</span>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block font-bold text-sm text-slate-700 mb-1">Ketik Nama Pemohon:</label>
                <input type="text" x-model="simulasiKtp.nama" placeholder="Contoh: Pak Budi Setiawan" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-sm text-slate-700 mb-1">Pilih RT Domisili:</label>
                <select x-model="simulasiKtp.rt" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                    <option value="01">RT 01 / RW 01</option>
                    <option value="02">RT 02 / RW 01</option>
                    <option value="03">RT 03 / RW 01</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-sm text-slate-700 mb-1">Lokasi Kehilangan:</label>
                <input type="text" x-model="simulasiKtp.lokasi" placeholder="Contoh: Pasar Kebonpedes" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
            </div>

            <button type="button" @click="generateSimulasiKtp()" class="btn-touch w-full py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl shadow transition">
                🚀 Coba Kirim Permohonan Simulasi
            </button>
        </div>

        <!-- Hasil Simulasi Interaktif -->
        <div x-show="simulasiKtpResult" x-cloak class="p-6 bg-emerald-50 rounded-2xl border-2 border-emerald-300 text-emerald-950 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">✅ Berhasil Disimulasikan!</span>
                <span class="text-xs font-mono px-2 py-0.5 bg-emerald-200 text-emerald-900 rounded font-bold">Kode Simulasi</span>
            </div>
            <div class="text-2xl font-black font-mono" x-text="simulasiKtpResult?.kode"></div>
            <p class="text-sm">
                Permohonan atas nama <strong x-text="simulasiKtpResult?.nama"></strong> (RT <span x-text="simulasiKtpResult?.rt"></span>) telah disimulasikan. Pada sistem nyata, data ini langsung masuk ke dashboard Ketua RT untuk diverifikasi.
            </p>
        </div>
    </div>

    <!-- 2. SIMULASI KALKULATOR GIZI BALITA -->
    <div x-show="mode === 'gizi'" x-cloak class="bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-md space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="text-xl font-black text-slate-900">Kalkulator Cepat Gizi & Stunting</h3>
            <span class="text-xs font-bold text-amber-700 bg-amber-50 px-3 py-1 rounded-full">Kader Posyandu</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-sm text-slate-700 mb-1">Usia Balita (Bulan):</label>
                <input type="number" x-model.number="simulasiGizi.usia" min="0" max="60" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
            </div>

            <div>
                <label class="block font-bold text-sm text-slate-700 mb-1">Tinggi Badan (cm):</label>
                <input type="number" step="0.5" x-model.number="simulasiGizi.tb" placeholder="Contoh: 75" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold text-emerald-800">
            </div>

            <div class="sm:col-span-2">
                <label class="block font-bold text-sm text-slate-700 mb-1">Berat Badan (kg):</label>
                <input type="number" step="0.1" x-model.number="simulasiGizi.bb" placeholder="Contoh: 9.2" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold text-emerald-800">
            </div>
        </div>

        <!-- Live Output Perhitungan -->
        <div class="p-6 bg-slate-50 rounded-2xl border-2 border-slate-200 space-y-2">
            <span class="text-xs font-bold text-slate-500 uppercase">Analisis Otomatis Sistem:</span>
            <div class="flex items-center gap-3">
                <span class="text-3xl" x-text="getSimulasiBadge().icon"></span>
                <div>
                    <div class="text-xl font-black text-slate-900" x-text="getSimulasiBadge().status"></div>
                    <p class="text-xs text-slate-600" x-text="getSimulasiBadge().saran"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function latihanSimulasi() {
        return {
            mode: 'ktp',
            simulasiKtp: { nama: '', rt: '01', lokasi: '' },
            simulasiKtpResult: null,

            simulasiGizi: { usia: 18, tb: 78, bb: 9.5 },

            generateSimulasiKtp() {
                if (!this.simulasiKtp.nama) {
                    alert('Silakan ketik nama pemohon terlebih dahulu.');
                    return;
                }
                const randomStr = Math.random().toString(36).substring(2, 6).toUpperCase();
                this.simulasiKtpResult = {
                    nama: this.simulasiKtp.nama,
                    rt: this.simulasiKtp.rt,
                    kode: 'SIMULASI-202610-' + randomStr
                };
            },

            getSimulasiBadge() {
                const tb = this.simulasiGizi.tb;
                const usia = this.simulasiGizi.usia;
                
                if (!tb || !usia) return { icon: '👶', status: 'Masukkan data tinggi & usia', saran: 'Kalkulator akan menghitung otomatis' };

                // Standar estimasi sederhana WHO
                const expectedTb = 50 + (usia * 1.8);
                if (tb < (expectedTb - 6)) {
                    return { icon: '🚨', status: 'Sangat Pendek (Severely Stunted)', saran: 'Perlu rujukan medis ke Bidan/Puskesmas dan PMT Pemulihan intensif.' };
                } else if (tb < (expectedTb - 3)) {
                    return { icon: '⚠️', status: 'Pendek (Stunted)', saran: 'Perlu Pemberian Makanan Tambahan (PMT Telur/Biskuit) dan pemantauan 1 bulan.' };
                } else {
                    return { icon: '✅', status: 'Tinggi Badan Normal & Sehat', saran: 'Pertumbuhan optimal sesuai grafik kurva balita sehat WHO.' };
                }
            }
        }
    }
</script>
@endsection
