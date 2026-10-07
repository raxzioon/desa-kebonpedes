@extends('layouts.app')

@section('title', 'Dashboard Kader Posyandu - ' . config('desa.nama_desa'))
@section('page_title', 'Dashboard Kader Posyandu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Sambutan Kader -->
    <div class="bg-gradient-to-r from-amber-700 via-amber-800 to-yellow-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="px-3.5 py-1 bg-amber-400/30 border border-amber-300/30 text-amber-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-2">
                👶 Pelayanan Posyandu & Balita
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight">
                Selamat Datang, {{ $user->name }}
            </h1>
            <p class="text-amber-100 text-base mt-1">
                {{ $user->jabatan ?? 'Kader Posyandu Desa Kebonpedes' }} &bull; Bersama Cegah Stunting Demi Generasi Sehat
            </p>
        </div>

        <div class="flex flex-wrap gap-3 shrink-0">
            <a href="{{ route('stunting.create') }}" class="btn-touch px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm rounded-2xl shadow-lg transition flex items-center gap-2">
                <span>➕</span> Catat Pemeriksaan Balita
            </a>
            <a href="{{ route('stunting.index') }}" class="btn-touch px-4 py-3 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-2xl border border-white/30 backdrop-blur-sm transition">
                📋 Daftar Semua Balita
            </a>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 1. KARTU STATISTIK METRIK GIZI & STUNTING -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-amber-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Total Balita Dipantau</span>
                <span class="text-2xl">👶</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-slate-900">{{ $totalBalita }}</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                Anak usia 0 - 5 tahun
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-emerald-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Tumbuh Normal</span>
                <span class="text-2xl">✅</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-emerald-700">{{ $totalNormal }}</div>
            <div class="text-xs text-emerald-600 mt-2 font-semibold">
                Tinggi & berat sesuai usia
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-amber-200">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Pendek (Stunted)</span>
                <span class="text-2xl">⚠️</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-amber-600">{{ $totalStunted }}</div>
            <div class="text-xs text-amber-700 mt-2 font-semibold">
                Pemberian PMT Pemulihan
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-md border-2 {{ $totalSevere > 0 ? 'border-rose-300 bg-rose-50/40' : 'border-slate-100' }}">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Sangat Pendek (Severe)</span>
                <span class="text-2xl">🚨</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-rose-600">{{ $totalSevere }}</div>
            <div class="text-xs text-rose-700 mt-2 font-bold">
                Rujukan Bidan / Puskesmas
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 2. BALITA PRIORITAS PENDAMPINGAN (INTERVENSI STUNTING) -->
    <!-- ========================================================= -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md p-6 sm:p-8 mb-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <div>
                <h2 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                    <span>🚨</span> Balita Perlu Intervensi & Pendampingan Khusus
                </h2>
                <p class="text-sm text-slate-600">
                    Daftar balita dengan status stunting atau gizi kurang yang memerlukan PMT (Pemberian Makanan Tambahan) dan kunjungan rumah.
                </p>
            </div>
            <span class="px-3.5 py-1 bg-rose-100 text-rose-900 font-bold text-xs rounded-full border border-rose-300">
                {{ $balitaPrioritas->count() }} Balita
            </span>
        </div>

        <div class="space-y-4">
            @foreach($balitaPrioritas as $b)
                <div class="p-5 rounded-2xl bg-amber-50/70 border-2 {{ $b->status_stunting === 'Sangat Pendek (Severely Stunted)' ? 'border-rose-300 bg-rose-50/50' : 'border-amber-300' }} flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black border {{ $b->status_badge['class'] }}">
                                {{ $b->status_stunting }}
                            </span>
                            <span class="text-xs text-slate-500 font-bold">Usia: {{ $b->usia_bulan }} Bulan &bull; RT {{ $b->rt }}/RW {{ $b->rw }}</span>
                        </div>
                        <h4 class="font-black text-xl text-slate-900">{{ $b->nama_anak }} ({{ $b->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }})</h4>
                        <p class="text-sm text-slate-700">
                            <strong>Orang Tua:</strong> Ibu {{ $b->nama_ibu }} / Bpk {{ $b->nama_ayah }} &bull; 
                            <strong>BB/TB:</strong> {{ $b->berat_badan }} kg / {{ $b->tinggi_badan }} cm
                        </p>
                        <p class="text-xs text-slate-600">
                            <strong>Intervensi:</strong> <span class="text-emerald-800 font-semibold">{{ $b->intervensi_diberikan ?? 'Pemberian Biskuit PMT & Vitamin' }}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('stunting.edit', $b->id) }}" class="btn-touch px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow transition">
                            ✏️ Perbarui Data Gizi
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 3. GRAFIK KONDISI GIZI & JADWAL POSYANDU -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Grafik Gizi -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h3 class="text-xl font-black text-slate-900 mb-1 flex items-center gap-2">
                <span>📊</span> Grafik Proporsi Kesehatan Balita
            </h3>
            <p class="text-xs text-slate-500 mb-6">Status gizi seluruh balita di posyandu desa</p>

            <div class="h-64 sm:h-72">
                <canvas id="chartGiziKader"></canvas>
            </div>
        </div>

        <!-- Pengingat Jadwal Posyandu & Edukasi Kader -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h3 class="text-xl font-black text-slate-900 mb-4 flex items-center gap-2">
                <span>🗓️</span> Jadwal & SOP Posyandu
            </h3>

            <div class="space-y-3 text-sm">
                <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-200">
                    <div class="font-bold text-emerald-900">Posyandu Melati 1 (RT 01)</div>
                    <div class="text-xs text-emerald-700">Setiap tanggal 10 bulan berjalan &bull; 08.00 WIB</div>
                </div>

                <div class="p-3 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="font-bold text-blue-900">Posyandu Mawar 2 (RT 02)</div>
                    <div class="text-xs text-blue-700">Setiap tanggal 15 bulan berjalan &bull; 08.30 WIB</div>
                </div>

                <div class="p-3 bg-purple-50 rounded-xl border border-purple-200">
                    <div class="font-bold text-purple-900">Posyandu Kenanga 3 (RT 03)</div>
                    <div class="text-xs text-purple-700">Setiap tanggal 20 bulan berjalan &bull; 08.00 WIB</div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-200">
                <a href="{{ route('panduan.show', 'panduan-kader-posyandu') }}" class="text-emerald-700 font-bold text-xs hover:underline flex items-center gap-1">
                    <span>📖</span> Buka Panduan Lengkap Kader Posyandu &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chartGiziKader').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartGiziLabels) !!},
                datasets: [{
                    label: 'Jumlah Balita',
                    data: {!! json_encode($chartGiziData) !!},
                    backgroundColor: ['#10b981', '#f59e0b', '#f43f5e', '#06b6d4'],
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 2 } } }
            }
        });
    });
</script>
@endsection
