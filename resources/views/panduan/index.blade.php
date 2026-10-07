@extends('layouts.app')

@section('title', 'Pusat Panduan & Glosarium Istilah Desa - ' . config('desa.nama_desa'))
@section('page_title', 'Pusat Panduan & Pelatihan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Hero Header -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white rounded-3xl p-8 md:p-12 shadow-xl mb-10 relative overflow-hidden">
        <div class="decorative-bg absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-4 py-1.5 bg-emerald-500/30 border border-emerald-300/30 text-emerald-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-3">
                📖 Pusat Edukasi & Bantuan Pelatihan
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                Pusat Panduan & Glosarium Istilah Desa
            </h1>
            <p class="text-base sm:text-lg text-emerald-100 leading-relaxed mb-6">
                Dirancang khusus dengan bahasa yang ramah, panduan bergambar, penjelasan istilah umum, dan mode latihan simulasi untuk aparatur baru maupun masyarakat lanjut usia.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('panduan.latihan') }}" class="btn-touch px-6 py-3.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-base rounded-2xl shadow-lg transition flex items-center gap-2">
                    <span>🎮</span> Buka Mode Latihan Mandiri (Simulasi)
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Kategori Panduan -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8">
        <a href="{{ route('panduan.index') }}" class="btn-touch px-5 py-2.5 rounded-2xl font-bold text-sm transition whitespace-nowrap {{ !request('kategori') ? 'bg-emerald-700 text-white shadow' : 'bg-white text-slate-700 border-2 border-slate-200 hover:bg-slate-50' }}">
            Semua Panduan
        </a>
        @foreach($kategoris as $k)
            <a href="{{ route('panduan.index', ['kategori' => $k]) }}" class="btn-touch px-5 py-2.5 rounded-2xl font-bold text-sm transition whitespace-nowrap {{ request('kategori') == $k ? 'bg-emerald-700 text-white shadow' : 'bg-white text-slate-700 border-2 border-slate-200 hover:bg-slate-50' }}">
                {{ $k }}
            </a>
        @endforeach
    </div>

    <!-- Grid Panduan & Glosarium -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @foreach($panduans as $p)
            <div class="bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-md hover:shadow-xl transition flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl font-bold mb-4 shadow-sm">
                        📖
                    </div>
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full">
                        {{ $p->kategori }} &bull; Sasaran: {{ $p->target_peran }}
                    </span>
                    <h3 class="font-black text-xl text-slate-900 mt-3 mb-2 leading-snug">
                        {{ $p->judul }}
                    </h3>
                    <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed mb-6">
                        {{ $p->ringkasan }}
                    </p>
                </div>

                <a href="{{ route('panduan.show', $p->slug) }}" class="btn-touch w-full py-3 px-4 bg-slate-900 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl text-center transition flex items-center justify-center gap-2">
                    <span>Baca Panduan Langkah Demi Langkah</span> &rarr;
                </a>
            </div>
        @endforeach
    </div>

    <!-- Kotak Mode Latihan -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 p-8 rounded-3xl border-2 border-amber-300 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="px-3 py-1 bg-amber-200 text-amber-900 text-xs font-black rounded-full uppercase tracking-wider">
                Ruang Latihan Aman
            </span>
            <h3 class="text-2xl font-black text-slate-900 mt-2">
                Ingin Mencoba Mengisi Data Tanpa Takut Salah?
            </h3>
            <p class="text-sm text-slate-700 mt-1 max-w-2xl leading-relaxed">
                Mode Latihan Mandiri memungkinkan Anda mencoba mengisi formulir kependudukan, pengajuan surat, atau penimbangan balita secara interaktif dengan data simulasi yang tidak akan mengubah data asli desa.
            </p>
        </div>

        <a href="{{ route('panduan.latihan') }}" class="btn-touch px-8 py-4 bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-base rounded-2xl shadow-md transition shrink-0">
            Mulai Latihan Simulasi &rarr;
        </a>
    </div>
</div>
@endsection
