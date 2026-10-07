@extends('layouts.app')

@section('title', 'Papan Gotong Royong & Relawan Desa - ' . config('desa.nama_desa'))
@section('page_title', 'Papan Gotong Royong')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Header Hero -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-800 to-teal-900 text-white rounded-3xl p-8 md:p-12 shadow-xl mb-10 relative overflow-hidden">
        <div class="decorative-bg absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-4 py-1.5 bg-emerald-400/30 border border-emerald-300/30 text-emerald-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-3">
                🤝 Guyub Rukun & Partisipasi Warga (SDG 11 & 17)
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                Papan Kegiatan Gotong Royong Desa
            </h1>
            <p class="text-base sm:text-lg text-emerald-100 leading-relaxed">
                Wujud nyata kebersamaan warga {{ config('desa.nama_desa') }}. Daftarkan diri Anda sebagai relawan kerja bakti, bakti sosial posyandu, dan santunan sesama.
            </p>
        </div>
    </div>

    <!-- Filter Kategori Kegiatan -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8">
        <a href="{{ route('gotong-royong.index') }}" class="btn-touch px-5 py-2.5 rounded-2xl font-bold text-sm transition whitespace-nowrap {{ !request('kategori') ? 'bg-emerald-700 text-white shadow' : 'bg-white text-slate-700 border-2 border-slate-200 hover:bg-slate-50' }}">
            Semua Kegiatan
        </a>
        @foreach($kategoris as $k)
            <a href="{{ route('gotong-royong.index', ['kategori' => $k]) }}" class="btn-touch px-5 py-2.5 rounded-2xl font-bold text-sm transition whitespace-nowrap {{ request('kategori') == $k ? 'bg-emerald-700 text-white shadow' : 'bg-white text-slate-700 border-2 border-slate-200 hover:bg-slate-50' }}">
                {{ $k }}
            </a>
        @endforeach
    </div>

    <!-- Grid Kegiatan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        @forelse($kegiatans as $kg)
            <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md hover:shadow-2xl transition transform hover:-translate-y-1 p-6 sm:p-8 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-900 font-bold text-xs rounded-full">
                            {{ $kg->kategori }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $kg->status_badge['class'] }}">
                            {{ $kg->status_badge['label'] }}
                        </span>
                    </div>

                    <h3 class="font-black text-2xl text-slate-900 mb-2 leading-snug">
                        {{ $kg->judul }}
                    </h3>

                    <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed mb-6">
                        {{ $kg->deskripsi }}
                    </p>

                    <!-- Info Waktu & Lokasi -->
                    <div class="space-y-2 bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs text-slate-700 mb-6">
                        <div class="flex items-center gap-2">
                            <span>📅</span>
                            <strong>{{ $kg->tanggal_kegiatan->translatedFormat('l, d F Y') }}</strong>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>⏰</span>
                            <span>{{ $kg->jam_kegiatan }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>📍</span>
                            <span>{{ $kg->lokasi }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>👤</span>
                            <span>PJ: {{ $kg->kontak_pj }} ({{ $kg->no_wa_pj }})</span>
                        </div>
                    </div>
                </div>

                <div>
                    <!-- Status Kuota Relawan -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span>Relawan Bergabung:</span>
                            <span class="text-emerald-800">{{ $kg->jumlah_relawan }} / {{ $kg->kuota_relawan }} Orang</span>
                        </div>
                        <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-emerald-600 h-full rounded-full" style="width: {{ min(100, ($kg->jumlah_relawan / max(1, $kg->kuota_relawan)) * 100) }}%"></div>
                        </div>
                    </div>

                    <a href="{{ route('gotong-royong.show', $kg->id) }}" class="btn-touch w-full py-3.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl text-center shadow transition flex items-center justify-center gap-2">
                        <span>🤝 Ikut Serta / Rincian</span> &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200 text-center">
                <span class="text-5xl block mb-2">🤝</span>
                <h3 class="text-xl font-bold text-slate-800">Tidak ada agenda kegiatan pada kategori ini</h3>
            </div>
        @endforelse
    </div>

    <div>
        {{ $kegiatans->links() }}
    </div>
</div>
@endsection
