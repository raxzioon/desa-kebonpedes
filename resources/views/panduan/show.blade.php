@extends('layouts.app')

@section('title', $panduan->judul . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Rincian Panduan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="mb-6">
        <a href="{{ route('panduan.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Pusat Panduan
        </a>
    </div>

    <div class="bg-white rounded-3xl border-2 border-slate-200 p-8 sm:p-12 shadow-xl mb-10">
        <div class="flex items-center gap-2 mb-3">
            <span class="px-3.5 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                {{ $panduan->kategori }}
            </span>
            <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-full">
                Peruntukan: {{ $panduan->target_peran }}
            </span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-4">
            {{ $panduan->judul }}
        </h1>

        <div class="p-4 bg-emerald-50 rounded-2xl border-l-4 border-emerald-600 text-emerald-950 font-medium text-base mb-8">
            {{ $panduan->ringkasan }}
        </div>

        <div class="prose prose-slate max-w-none text-base sm:text-lg leading-relaxed space-y-4 text-slate-700 border-t border-slate-100 pt-6">
            {!! $panduan->konten !!}
        </div>
    </div>

    <!-- Panduan Lainnya -->
    @if($panduanLain->isNotEmpty())
        <div>
            <h3 class="text-2xl font-black text-slate-900 mb-6">Panduan Lain yang Mungkin Membantu:</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($panduanLain as $pl)
                    <a href="{{ route('panduan.show', $pl->slug) }}" class="p-5 bg-white rounded-2xl border-2 border-slate-200 hover:border-emerald-500 shadow-sm hover:shadow-md transition block">
                        <span class="text-xs font-bold text-emerald-700">{{ $pl->kategori }}</span>
                        <h4 class="font-black text-lg text-slate-900 mt-1">{{ $pl->judul }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
