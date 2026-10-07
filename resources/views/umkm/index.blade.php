@extends('layouts.app')

@section('title', 'Pasar UMKM & Produk Lokal - ' . config('desa.nama_desa'))
@section('page_title', 'Pasar UMKM Desa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Header Hero UMKM -->
    <div class="bg-gradient-to-r from-teal-800 via-emerald-800 to-slate-900 text-white rounded-3xl p-8 md:p-12 shadow-xl mb-10 relative overflow-hidden">
        <div class="decorative-bg absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-4 py-1.5 bg-teal-400/30 border border-teal-300/30 text-teal-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-3">
                🛍️ Pemberdayaan Ekonomi & Pasar Tradisional (SDG 8)
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                Etalase Produk UMKM {{ config('desa.nama_desa') }}
            </h1>
            <p class="text-base sm:text-lg text-teal-100 leading-relaxed">
                Dukung produk karya dan hasil kebun warga desa. Hubungi langsung pemilik usaha melalui WhatsApp atau temukan di Pasar Tradisional Kebonpedes.
            </p>
        </div>
    </div>

    <!-- Filter Kategori & Pencarian Produk -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-sm mb-10">
        <form method="GET" action="{{ route('umkm.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <!-- Pencarian -->
            <div class="sm:col-span-6">
                <label for="umkm_q" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    🔍 Cari Nama Produk atau Pemilik:
                </label>
                <input type="text" name="q" id="umkm_q" value="{{ request('q') }}" placeholder="Ketik nama makanan, kerajinan, dsb..." class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-teal-600 focus:ring-4 focus:ring-teal-100">
            </div>

            <!-- Filter Kategori -->
            <div class="sm:col-span-4">
                <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Kategori Produk:
                </label>
                <select name="kategori" id="kategori" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-semibold">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="btn-touch w-full py-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-base rounded-2xl shadow transition">
                    Cari
                </button>
                <a href="{{ route('umkm.index') }}" class="btn-touch px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-base rounded-2xl border border-slate-300">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Grid Produk UMKM -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @forelse($umkms as $u)
            <div class="bg-white rounded-3xl border-2 border-slate-200 overflow-hidden shadow-md hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col justify-between">
                <div>
                    <!-- Visual Icon Header -->
                    <div class="h-48 bg-gradient-to-br from-teal-50 via-emerald-50 to-amber-50 flex items-center justify-center p-4 relative border-b-2 border-slate-100">
                        <span class="text-7xl">
                            @if(str_contains($u->kategori, 'Makanan') || str_contains($u->kategori, 'Pangan')) 🍯
                            @elseif(str_contains($u->kategori, 'Kerajinan')) 🧺
                            @elseif(str_contains($u->kategori, 'Pertanian') || str_contains($u->kategori, 'Peternakan')) 🥬
                            @elseif(str_contains($u->kategori, 'Jasa') || str_contains($u->kategori, 'Konveksi')) 🧵
                            @else 🛍️
                            @endif
                        </span>
                        <span class="absolute top-3 right-3 px-3 py-1 bg-white/95 backdrop-blur-sm text-slate-900 text-xs font-black rounded-xl shadow-sm border border-slate-200">
                            {{ $u->kategori }}
                        </span>
                    </div>

                    <div class="p-6">
                        <a href="{{ route('umkm.show', $u->id) }}" class="block">
                            <h3 class="font-black text-xl text-slate-900 mb-1 leading-snug line-clamp-1 hover:text-teal-700 transition">
                                {{ $u->nama_produk }}
                            </h3>
                        </a>
                        <p class="text-xs font-bold text-teal-800 mb-3">
                            Pemilik: {{ $u->nama_pemilik }} &bull; RT {{ $u->rt }}
                        </p>

                        <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-4">
                            {{ $u->deskripsi }}
                        </p>

                        <div class="text-2xl font-black text-slate-950 mb-2">
                            {{ $u->formatted_harga }}
                            <span class="text-xs font-normal text-slate-500">/ {{ $u->satuan }}</span>
                        </div>

                        <div class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl flex items-center gap-1.5 mb-4 font-medium">
                            <span>📍</span>
                            <span class="line-clamp-1">{{ $u->lokasi_pasar }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 space-y-2">
                    <a href="{{ $u->wa_link }}" target="_blank" class="w-full btn-touch py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-base rounded-2xl shadow-md transition flex items-center justify-center gap-2">
                        <span class="text-xl">💬</span>
                        <span>Hubungi via WhatsApp</span>
                    </a>

                    <a href="{{ route('umkm.show', $u->id) }}" class="w-full text-center py-2 text-xs font-bold text-slate-500 hover:text-slate-800 block">
                        Lihat Rincian Produk &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200 text-center">
                <span class="text-5xl block mb-2">🛍️</span>
                <h3 class="text-xl font-bold text-slate-800">Tidak ada produk yang cocok</h3>
                <p class="text-sm text-slate-500 mt-1">Coba pilih kategori lain atau reset kata kunci pencarian.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $umkms->links() }}
    </div>
</div>
@endsection
