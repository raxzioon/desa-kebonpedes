@extends('layouts.app')

@section('title', config('desa.nama_desa') . ' - Sistem Informasi dan Layanan Desa')

@section('content')
<div class="space-y-10 max-w-6xl mx-auto px-4 py-8">

    <!-- ========================================================= -->
    <!-- 1. HEADER HALAMAN BERANDA (RATA KIRI, LATAR NETRAL POLOS) -->
    <!-- ========================================================= -->
    <section class="bg-white border border-stone-200 rounded-lg p-6 sm:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-8 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-stone-100 border border-stone-200 rounded text-xs text-slate-700">
                    <span class="w-2 h-2 rounded-full bg-desa-700"></span>
                    <span>Pelayanan Terbuka Warga {{ config('desa.nama_desa') }}</span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
                    Layanan dan Informasi Desa Kebonpedes
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-prose-desa">
                    Pusat layanan surat keterangan warga, pemantauan kesehatan gizi balita, etalase usaha mikro warga, dan agenda gotong royong kemasyarakatan.
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-3 text-sm text-slate-600">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-desa-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><strong>Jam Pelayanan Kantor:</strong> Senin – Jumat, 08.00 – 15.00 WIB</span>
                    </div>
                </div>
            </div>

            <!-- Cek Cepat Status Pelacakan Surat KTP -->
            <div class="lg:col-span-4 bg-stone-50 border border-stone-200 rounded-lg p-5">
                <h2 class="text-sm font-bold text-slate-900 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-desa-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Lacak Status Surat KTP</span>
                </h2>
                <p class="text-xs text-slate-600 mb-3">
                    Masukkan kode pelacakan yang diberikan saat pengajuan surat.
                </p>
                <form action="{{ route('ktp-hilang.lacak') }}" method="GET" class="space-y-2">
                    <div>
                        <label for="quick_kode" class="sr-only">Kode Pelacakan</label>
                        <input type="text" name="kode_lacak" id="quick_kode" required placeholder="Contoh: KTP-202610-A19F" class="w-full px-3 py-2 text-sm font-mono uppercase bg-white border border-stone-300 rounded focus:outline-none focus:border-desa-700 focus:ring-1 focus:ring-desa-700">
                    </div>
                    <button type="submit" class="btn-touch w-full px-4 py-2 bg-desa-700 hover:bg-desa-800 text-white font-bold text-sm rounded transition flex items-center justify-center gap-2">
                        <span>Cek Status Sekarang</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 2. TIGA TAUTAN LAYANAN UTAMA (DAFTAR BESAR & JELAS) -->
    <!-- ========================================================= -->
    <section>
        <div class="mb-4">
            <h2 class="text-xl font-bold text-slate-900">Layanan Utama Warga</h2>
            <p class="text-sm text-slate-600">Pilih salah satu layanan publik yang tersedia di bawah ini:</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Layanan 1: KTP Hilang -->
            <div class="bg-white border border-stone-200 rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded bg-stone-100 text-desa-700 flex items-center justify-center mb-4 border border-stone-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Lapor KTP Hilang</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6">
                        Pengajuan surat keterangan kehilangan KTP secara daring tanpa perlu antre di kantor desa.
                    </p>
                </div>
                <div class="space-y-2 pt-2 border-t border-stone-100">
                    <a href="{{ route('ktp-hilang.create') }}" class="btn-touch w-full px-4 py-2.5 bg-desa-700 hover:bg-desa-800 text-white font-bold text-sm rounded transition text-center flex items-center justify-center gap-2">
                        <span>Buat Pengajuan Surat</span>
                    </a>
                    <a href="{{ route('ktp-hilang.lacak') }}" class="w-full text-center py-2 text-xs font-bold text-desa-700 hover:underline block">
                        Lacak Pengajuan Sebelumnya &rarr;
                    </a>
                </div>
            </div>

            <!-- Layanan 2: UMKM Desa -->
            <div class="bg-white border border-stone-200 rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded bg-stone-100 text-desa-700 flex items-center justify-center mb-4 border border-stone-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pasar & UMKM Desa</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6">
                        Etalase produk hasil bumi dan kerajinan tangan warga yang dijual di pasar desa dan via WhatsApp.
                    </p>
                </div>
                <div class="pt-2 border-t border-stone-100">
                    <a href="{{ route('umkm.index') }}" class="btn-touch w-full px-4 py-2.5 bg-white border border-stone-300 hover:bg-stone-50 text-slate-800 font-bold text-sm rounded transition text-center flex items-center justify-center gap-2">
                        <span>Lihat Semua Produk ({{ $totalUmkm }})</span>
                    </a>
                </div>
            </div>

            <!-- Layanan 3: Gotong Royong -->
            <div class="bg-white border border-stone-200 rounded-lg p-6 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded bg-stone-100 text-desa-700 flex items-center justify-center mb-4 border border-stone-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Gotong Royong & Kegiatan</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-6">
                        Informasi kerja bakti lingkungan, posyandu balita, dan pendaftaran relawan kemasyarakatan.
                    </p>
                </div>
                <div class="pt-2 border-t border-stone-100">
                    <a href="{{ route('gotong-royong.index') }}" class="btn-touch w-full px-4 py-2.5 bg-white border border-stone-300 hover:bg-stone-50 text-slate-800 font-bold text-sm rounded transition text-center flex items-center justify-center gap-2">
                        <span>Lihat Agenda Kegiatan</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 3. STATISTIK DESA DALAM SATU BARIS ANGKA SEDERHANA -->
    <!-- ========================================================= -->
    <section class="bg-white border border-stone-200 rounded-lg p-6">
        <div class="mb-4">
            <h2 class="text-base font-bold text-slate-900">Ringkasan Data Statistik Desa</h2>
            <p class="text-xs text-slate-500">Data agregat non-rahasia terkini dari pangkalan data sistem informasi desa:</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 divide-y md:divide-y-0 md:divide-x divide-stone-200">
            <!-- Stat 1 -->
            <div class="pt-3 md:pt-0 md:px-4 first:pl-0">
                <p class="text-xs text-slate-500 font-normal">Jumlah Penduduk</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalPenduduk, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ $totalLaki }} Laki-laki &bull; {{ $totalPerempuan }} Perempuan</p>
            </div>

            <!-- Stat 2 -->
            <div class="pt-3 md:pt-0 md:px-4">
                <p class="text-xs text-slate-500 font-normal">Kepala Keluarga</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalKk, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Tersebar di wilayah RT/RW</p>
            </div>

            <!-- Stat 3 -->
            <div class="pt-3 md:pt-0 md:px-4">
                <p class="text-xs text-slate-500 font-normal">Balita Terpantau</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalBalita, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-600 mt-0.5">{{ $totalBalitaNormal }} Status Gizi Normal</p>
            </div>

            <!-- Stat 4 -->
            <div class="pt-3 md:pt-0 md:px-4 last:pr-0">
                <p class="text-xs text-slate-500 font-normal">Usaha Mikro (UMKM)</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($totalUmkm, 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Unit Usaha Terdaftar</p>
            </div>
        </div>
    </section>

    <!-- ========================================================= -->
    <!-- 4. PENGUMUMAN & KEGIATAN WARGA TERBARU -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Kolom Kiri: Agenda Kegiatan & Pengumuman -->
        <div class="lg:col-span-8 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-stone-200">
                <h2 class="text-xl font-bold text-slate-900">Agenda & Pengumuman Desa</h2>
                <a href="{{ route('gotong-royong.index') }}" class="text-xs font-bold text-desa-700 hover:underline">
                    Semua Kegiatan &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse($kegiatans as $kg)
                    <div class="bg-white border border-stone-200 rounded-lg p-5 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="space-y-1.5 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 bg-stone-100 border border-stone-200 text-slate-700 text-xs rounded">
                                    {{ $kg->kategori }}
                                </span>
                                <span class="text-xs text-slate-500">
                                    {{ $kg->tanggal_kegiatan->translatedFormat('l, d F Y') }} &bull; {{ $kg->jam_kegiatan }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900">
                                <a href="{{ route('gotong-royong.show', $kg->id) }}" class="hover:text-desa-700">
                                    {{ $kg->judul }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">
                                {{ $kg->deskripsi }}
                            </p>

                            <p class="text-xs text-slate-500">
                                <strong>Lokasi:</strong> {{ $kg->lokasi }} &bull; <strong>Kontak PJ:</strong> {{ $kg->kontak_pj }} ({{ $kg->no_wa_pj }})
                            </p>
                        </div>

                        <div class="shrink-0 sm:text-right flex sm:flex-col items-center sm:items-end justify-between gap-2 border-t sm:border-t-0 pt-3 sm:pt-0 border-stone-100">
                            <span class="text-xs text-slate-600">
                                Relawan: <strong>{{ $kg->jumlah_relawan }} / {{ $kg->kuota_relawan }}</strong>
                            </span>
                            <a href="{{ route('gotong-royong.show', $kg->id) }}" class="btn-touch px-3 py-1.5 bg-desa-700 hover:bg-desa-800 text-white text-xs font-bold rounded transition">
                                Ikut Serta
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-stone-200 rounded-lg p-6 text-center text-slate-500 text-sm">
                        Belum ada kegiatan gotong royong yang dijadwalkan saat ini.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kolom Kanan: Sapaan Kepala Desa & Informasi Pelayanan -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Kotak Sapaan Kepala Desa -->
            <div class="bg-white border border-stone-200 rounded-lg p-5 space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-stone-200">
                    <!-- Placeholder Foto Netral -->
                    <div class="w-12 h-12 rounded bg-stone-100 border border-stone-200 text-slate-600 flex items-center justify-center shrink-0 font-bold text-sm">
                        <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">{{ config('desa.nama_kades') }}</h3>
                        <p class="text-xs text-slate-500">{{ config('desa.sebutan_kepala_desa') }} {{ config('desa.nama_desa') }}</p>
                    </div>
                </div>

                <blockquote class="text-xs text-slate-600 italic leading-relaxed border-l-2 border-desa-700 pl-3">
                    "Sistem informasi ini dirancang untuk memudahkan warga dalam mengurus administrasi desa secara tertib, terbuka, dan mengedepankan semangat gotong royong."
                </blockquote>

                <div class="text-xs text-slate-500 pt-2 border-t border-stone-100 space-y-1">
                    <p><strong>Alamat Kantor:</strong> {{ config('desa.alamat_kantor') }}</p>
                    <p><strong>Telepon / WhatsApp:</strong> {{ config('desa.telepon') }}</p>
                </div>
            </div>

            <!-- Panduan Penggunaan Singkat -->
            <div class="bg-stone-50 border border-stone-200 rounded-lg p-5">
                <h3 class="text-sm font-bold text-slate-900 mb-2">Panduan Penggunaan</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-3">
                    Butuh petunjuk langkah demi langkah pengisian form atau penjelasan istilah kependudukan?
                </p>
                <a href="{{ route('panduan.index') }}" class="text-xs font-bold text-desa-700 hover:underline flex items-center gap-1">
                    <span>Buka Pusat Panduan & Glosarium</span> &rarr;
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 5. ETALASE PRODUK UMKM DESA PILIHAN -->
    <!-- ========================================================= -->
    <section class="space-y-4">
        <div class="flex items-center justify-between pb-2 border-b border-stone-200">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Produk Usaha Warga (UMKM)</h2>
                <p class="text-xs text-slate-500">Hasil bumi dan olahan pangan karya warga Desa Kebonpedes:</p>
            </div>
            <a href="{{ route('umkm.index') }}" class="text-xs font-bold text-desa-700 hover:underline">
                Lihat Semua ({{ $totalUmkm }}) &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredUmkms as $u)
                <div class="bg-white border border-stone-200 rounded-lg p-4 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span class="px-2 py-0.5 bg-stone-100 border border-stone-200 rounded text-slate-700">
                                {{ $u->kategori }}
                            </span>
                            <span>{{ $u->lokasi_pasar }}</span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 leading-snug">
                            {{ $u->nama_produk }}
                        </h3>
                        
                        <p class="text-xs text-slate-500">
                            Usaha: <strong>{{ $u->nama_pemilik }}</strong> ({{ $u->nama_usaha }})
                        </p>

                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ $u->deskripsi }}
                        </p>

                        <div class="pt-2 text-sm font-bold text-desa-700">
                            {{ $u->formatted_harga }} <span class="text-xs font-normal text-slate-500">/ {{ $u->satuan }}</span>
                        </div>
                    </div>

                    <div class="pt-4 mt-3 border-t border-stone-100">
                        <a href="{{ $u->wa_link }}" target="_blank" class="btn-touch w-full px-3 py-2 bg-white border border-stone-300 hover:bg-stone-50 text-slate-800 text-xs font-bold rounded transition text-center flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4 text-desa-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <span>Hubungi Penjual</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
