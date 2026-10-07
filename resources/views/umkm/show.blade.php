@extends('layouts.app')

@section('title', $umkm->nama_produk . ' - UMKM ' . config('desa.nama_desa'))
@section('page_title', 'Rincian Produk UMKM')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="mb-6">
        <a href="{{ route('umkm.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Pasar UMKM Desa
        </a>
    </div>

    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-xl overflow-hidden mb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 p-6 sm:p-10 items-center">
            <!-- Visual Icon -->
            <div class="md:col-span-5 bg-gradient-to-br from-teal-100 via-emerald-50 to-amber-100 rounded-3xl h-72 sm:h-96 flex items-center justify-center p-6 border-2 border-slate-200">
                <span class="text-8xl sm:text-9xl">
                    @if(str_contains($umkm->kategori, 'Makanan') || str_contains($umkm->kategori, 'Pangan')) 🍯
                    @elseif(str_contains($umkm->kategori, 'Kerajinan')) 🧺
                    @elseif(str_contains($umkm->kategori, 'Pertanian') || str_contains($umkm->kategori, 'Peternakan')) 🥬
                    @else 🛍️
                    @endif
                </span>
            </div>

            <!-- Detail & Pemesanan -->
            <div class="md:col-span-7 space-y-6">
                <div>
                    <span class="px-3.5 py-1 bg-teal-100 text-teal-900 font-bold text-xs rounded-full uppercase tracking-wider inline-block mb-2">
                        {{ $umkm->kategori }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ $umkm->nama_produk }}
                    </h1>
                    <div class="text-3xl font-black text-emerald-800 mt-2">
                        {{ $umkm->formatted_harga }}
                        <span class="text-sm font-normal text-slate-500">/ {{ $umkm->satuan }}</span>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-sm space-y-1">
                    <p><strong>Nama Usaha:</strong> {{ $umkm->nama_usaha }}</p>
                    <p><strong>Pemilik Usaha:</strong> {{ $umkm->nama_pemilik }} (Warga RT {{ $umkm->rt }} / RW {{ $umkm->rw }})</p>
                    <p><strong>Ketersediaan di Pasar:</strong> {{ $umkm->lokasi_pasar }}</p>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-1">Deskripsi Produk:</h3>
                    <p class="text-base text-slate-600 leading-relaxed">
                        {{ $umkm->deskripsi }}
                    </p>
                </div>

                <div class="pt-2">
                    <a href="{{ $umkm->wa_link }}" target="_blank" class="btn-touch w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-lg rounded-2xl shadow-xl hover:shadow-2xl transition flex items-center justify-center gap-3">
                        <span class="text-2xl">💬</span>
                        <span>Pesan Sekarang via WhatsApp</span>
                    </a>
                    <p class="text-xs text-center text-slate-400 mt-2">
                        Pesan langsung terkirim ke pemilik produk tanpa potongan biaya.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Lainnya -->
    @if($produkLain->isNotEmpty())
        <div>
            <h3 class="text-2xl font-black text-slate-900 mb-6">Produk UMKM Lainnya:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($produkLain as $pl)
                    <div class="bg-white p-5 rounded-3xl border-2 border-slate-200 shadow-sm flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-bold text-teal-700">{{ $pl->kategori }}</span>
                            <h4 class="font-black text-lg text-slate-900 mt-1 mb-1">{{ $pl->nama_produk }}</h4>
                            <p class="text-sm font-black text-emerald-800 mb-3">{{ $pl->formatted_harga }}</p>
                        </div>
                        <a href="{{ route('umkm.show', $pl->id) }}" class="btn-touch px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl text-center">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
