@extends('layouts.app')

@section('title', 'Dashboard Kepala Desa - ' . config('desa.nama_desa'))
@section('page_title', 'Dashboard Kepala Desa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Sambutan Kades -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="px-3.5 py-1 bg-emerald-500/30 border border-emerald-300/30 text-emerald-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-2">
                🏛️ Hak Akses Penuh: Kepala Desa
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight">
                Selamat Datang, {{ $user->name }}
            </h1>
            <p class="text-emerald-100 text-base mt-1">
                Pusat pengawasan seluruh data kependudukan, kesehatan gizi balita, dan persetujuan surat resmi {{ config('desa.nama_desa') }}.
            </p>
        </div>

        <div class="flex flex-wrap gap-3 shrink-0">
            <a href="{{ route('audit-log.index') }}" class="btn-touch px-5 py-3 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-2xl border border-white/30 backdrop-blur-sm transition flex items-center gap-2">
                <span>📜</span> Riwayat Audit Log
            </a>
            <a href="{{ route('penduduk.index') }}" class="btn-touch px-5 py-3 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm rounded-2xl shadow-lg transition flex items-center gap-2">
                <span>👥</span> Kelola Semua Warga
            </a>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 1. KARTU STATISTIK METRIK TERBESAR (LARGE STATS CALLOUT) -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
        <!-- Total Penduduk -->
        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-emerald-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Total Penduduk</span>
                <span class="text-2xl">👥</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-slate-900">{{ $totalPenduduk }}</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                {{ $totalKk }} Kepala Keluarga (KK)
            </div>
        </div>

        <!-- Perlu Persetujuan Kades (High Priority Callout) -->
        <div class="bg-white rounded-3xl p-6 shadow-md border-2 {{ $totalMenunggu > 0 ? 'border-rose-300 bg-rose-50/50' : 'border-slate-100' }}">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span class="{{ $totalMenunggu > 0 ? 'text-rose-800' : '' }}">Perlu Persetujuan</span>
                <span class="text-2xl">⏳</span>
            </div>
            <div class="text-4xl md:text-5xl font-black {{ $totalMenunggu > 0 ? 'text-rose-600' : 'text-slate-900' }}">{{ $totalMenunggu }}</div>
            <div class="text-xs {{ $totalMenunggu > 0 ? 'text-rose-700 font-bold' : 'text-slate-500' }} mt-2">
                Permohonan surat & mutasi
            </div>
        </div>

        <!-- Balita Terpantau & Stunting -->
        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-amber-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Balita Terpantau</span>
                <span class="text-2xl">👶</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-slate-900">{{ $totalBalita }}</div>
            <div class="text-xs text-amber-700 font-bold mt-2">
                {{ $totalStunting }} Balita Perlu Intervensi
            </div>
        </div>

        <!-- UMKM & Gotong Royong -->
        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-teal-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>UMKM & Kegiatan</span>
                <span class="text-2xl">🏪</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-slate-900">{{ $totalUmkm }}</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                {{ $totalKegiatan }} Agenda Gotong Royong
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 2. ANTREAN PERSETUJUAN KEPALA DESA (WORKFLOW APPROVAL) -->
    <!-- ========================================================= -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md p-6 sm:p-8 mb-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <div>
                <h2 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                    <span>⚡</span> Antrean Surat & Permohonan Warga
                </h2>
                <p class="text-sm text-slate-600">
                    Daftar permohonan yang telah diverifikasi RT dan menunggu persetujuan / tanda tangan Kepala Desa.
                </p>
            </div>
            <span class="px-3.5 py-1 bg-amber-100 text-amber-900 font-bold text-xs rounded-full border border-amber-300">
                {{ $totalMenunggu }} Menunggu
            </span>
        </div>

        @if($totalMenunggu === 0)
            <div class="text-center py-12 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <span class="text-5xl block mb-2">🎉</span>
                <h3 class="text-lg font-black text-slate-800">Semua Permohonan Telah Diproses!</h3>
                <p class="text-sm text-slate-500">Tidak ada antrean surat pindah, kematian, atau KTP hilang yang tertunda.</p>
            </div>
        @else
            <div class="space-y-4">
                <!-- 1. Permohonan Pindah Warga -->
                @foreach($antreanPindah as $p)
                    <div class="p-5 rounded-2xl bg-amber-50/60 border-2 border-amber-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 text-xs font-bold rounded-md">Surat Pindah Warga</span>
                                <span class="text-xs text-slate-500 font-mono">{{ $p->no_surat_pengantar }}</span>
                            </div>
                            <h4 class="font-black text-lg text-slate-900">{{ $p->penduduk->nama ?? 'Warga' }}</h4>
                            <p class="text-sm text-slate-700">
                                <strong>Tujuan:</strong> {{ $p->desa_kelurahan_tujuan }}, {{ $p->kabupaten_kota_tujuan }} &bull; <strong>Alasan:</strong> {{ $p->alasan_pindah }}
                            </p>
                            <p class="text-xs text-slate-500">Diajukan oleh: {{ $p->diajukanOleh->name ?? 'Ketua RT' }}</p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ route('pindah.approve', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Apakah Anda yakin menyetujui surat pindah untuk warga ini?')" class="btn-touch px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-1">
                                    <span>✅</span> Setujui & Terbitkan
                                </button>
                            </form>
                            <form action="{{ route('pindah.reject', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Tolak permohonan surat pindah ini?')" class="btn-touch px-4 py-2.5 bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold text-sm rounded-xl border border-rose-300 transition">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- 2. Permohonan Warga Meninggal -->
                @foreach($antreanKematian as $k)
                    <div class="p-5 rounded-2xl bg-rose-50/60 border-2 border-rose-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-rose-100 text-rose-800 text-xs font-bold rounded-md">Pencatatan Kematian</span>
                                <span class="text-xs text-slate-500">Tgl: {{ $k->tanggal_kematian->format('d/m/Y') }}</span>
                            </div>
                            <h4 class="font-black text-lg text-slate-900">Almarhum/Almarhumah: {{ $k->penduduk->nama ?? 'Warga' }}</h4>
                            <p class="text-sm text-slate-700">
                                <strong>Tempat:</strong> {{ $k->tempat_kematian }} &bull; <strong>Sebab:</strong> {{ $k->sebab_kematian }} &bull; <strong>Pelapor:</strong> {{ $k->nama_pelapor }} ({{ $k->hubungan_pelapor }})
                            </p>
                            <p class="text-xs text-slate-500">Diajukan oleh: {{ $k->diajukanOleh->name ?? 'Ketua RT' }}</p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ route('kematian.approve', $k->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Konfirmasi pencatatan kematian warga dan perbarui status kependudukan?')" class="btn-touch px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-1">
                                    <span>✅</span> Setujui & Catat
                                </button>
                            </form>
                            <form action="{{ route('kematian.reject', $k->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Tolak pencatatan ini?')" class="btn-touch px-4 py-2.5 bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold text-sm rounded-xl border border-rose-300 transition">
                                    Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- 3. Permohonan KTP Hilang (Diverifikasi RT) -->
                @foreach($antreanKtp as $ktp)
                    <div class="p-5 rounded-2xl bg-teal-50/60 border-2 border-teal-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-teal-100 text-teal-800 text-xs font-bold rounded-md">Surat KTP Hilang</span>
                                <span class="text-xs text-slate-500 font-mono font-bold">{{ $ktp->kode_lacak }}</span>
                                <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-800 rounded font-semibold">Terverifikasi RT {{ $ktp->rt }}/RW {{ $ktp->rw }}</span>
                            </div>
                            <h4 class="font-black text-lg text-slate-900">{{ $ktp->nama_pemohon }} (NIK: {{ $ktp->masked_nik }})</h4>
                            <p class="text-sm text-slate-700">
                                <strong>Lokasi Hilang:</strong> {{ $ktp->lokasi_kehilangan }} &bull; <strong>Catatan RT:</strong> {{ $ktp->catatan_rt ?? 'Lengkap' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ route('ktp-hilang.kades-approve', $ktp->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-touch px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-1">
                                    <span>✍️</span> Terbitkan Nomor Surat
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ========================================================= -->
    <!-- 3. GRAFIK VISUAL REAL DATA (CHART.JS) -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        <!-- Grafik 1: Sebaran Penduduk per RT -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h3 class="text-xl font-black text-slate-900 mb-1 flex items-center gap-2">
                <span>📊</span> Sebaran Penduduk per RT / RW
            </h3>
            <p class="text-xs text-slate-500 mb-6">Grafik dihitung otomatis dari data penduduk tersimpan</p>

            <div class="h-64 sm:h-72">
                <canvas id="chartRt"></canvas>
            </div>
        </div>

        <!-- Grafik 2: Status Gizi Balita -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h3 class="text-xl font-black text-slate-900 mb-1 flex items-center gap-2">
                <span>🥧</span> Kondisi Gizi & Stunting
            </h3>
            <p class="text-xs text-slate-500 mb-6">Klasifikasi kesehatan balita Posyandu</p>

            <div class="h-64 sm:h-72 flex items-center justify-center">
                <canvas id="chartGizi"></canvas>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 4. RIWAYAT AUDIT LOG TERBARU (AKUNTABILITAS & ETIKA) -->
    <!-- ========================================================= -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <div>
                <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                    <span>📜</span> Log Audit Aktivitas Sistem Terkini
                </h3>
                <p class="text-xs text-slate-500">Merekam jejak akses, perubahan data, dan persetujuan oleh aparatur desa</p>
            </div>
            <a href="{{ route('audit-log.index') }}" class="text-sm font-bold text-emerald-700 hover:underline">
                Buka Riwayat Lengkap &rarr;
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($auditLogs as $log)
                <div class="py-3 flex items-start justify-between gap-4 text-sm">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded font-mono text-xs font-bold">{{ $log->aksi }}</span>
                            <span class="font-bold text-slate-800">{{ $log->user_name }}</span>
                            <span class="text-xs text-slate-400">({{ $log->user_role }})</span>
                        </div>
                        <p class="text-slate-600 text-xs leading-relaxed">{{ $log->deskripsi }}</p>
                    </div>
                    <span class="text-xs text-slate-400 font-mono whitespace-nowrap">
                        {{ $log->created_at->diffForHumans() }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Chart.js Initialization Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Chart Sebaran RT
        const ctxRt = document.getElementById('chartRt').getContext('2d');
        new Chart(ctxRt, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartRtLabels) !!},
                datasets: [{
                    label: 'Jumlah Warga',
                    data: {!! json_encode($chartRtData) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 2 } }
                }
            }
        });

        // 2. Chart Gizi Balita
        const ctxGizi = document.getElementById('chartGizi').getContext('2d');
        new Chart(ctxGizi, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartGiziLabels) !!},
                datasets: [{
                    data: {!! json_encode($chartGiziData) !!},
                    backgroundColor: ['#10b981', '#f59e0b', '#f43f5e', '#06b6d4'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>
@endsection
