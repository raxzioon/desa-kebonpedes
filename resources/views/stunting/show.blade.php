@extends('layouts.app')

@section('title', 'Detail Gizi Balita: ' . $stunting->nama_anak . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Rincian Kesehatan Balita')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('stunting.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
                &larr; Kembali ke Data Balita
            </a>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-1">
                {{ $stunting->nama_anak }}
            </h1>
            <p class="text-sm text-slate-600">
                Usia: <strong>{{ $stunting->usia_bulan }} Bulan</strong> &bull; Posyandu: {{ $stunting->posyandu_nama }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('stunting.edit', $stunting->id) }}" class="btn-touch px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-2">
                <span>✏️</span> Ubah Data
            </a>
        </div>
    </div>

    <!-- Status Badge Card -->
    <div class="p-6 rounded-3xl border-2 {{ $stunting->status_stunting === 'Normal' ? 'bg-emerald-50 border-emerald-300' : 'bg-amber-50 border-amber-300' }} shadow-md mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Status Stunting Terkini</span>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 flex items-center gap-2">
                <span>{{ $stunting->status_stunting }}</span>
            </div>
            <p class="text-sm text-slate-700 mt-1">
                Klasifikasi Gizi: <strong>{{ $stunting->status_gizi }}</strong>
            </p>
        </div>

        <div class="text-right sm:border-l-2 sm:border-slate-300 sm:pl-6">
            <span class="text-xs font-bold text-slate-500 uppercase">Terakhir Diperiksa</span>
            <div class="text-lg font-bold text-slate-900">{{ $stunting->tanggal_pemeriksaan->translatedFormat('d F Y') }}</div>
            <div class="text-xs text-slate-500">Oleh: {{ $stunting->kader->name ?? 'Kader Posyandu' }}</div>
        </div>
    </div>

    <!-- Hasil Pengukuran Fisik -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border-2 border-slate-200 shadow-md space-y-6">
        <h3 class="text-lg font-black text-slate-900 pb-3 border-b border-slate-100">
            📊 Hasil Pengukuran Fisik
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-4 bg-slate-50 rounded-2xl text-center">
                <span class="text-xs text-slate-500 font-bold uppercase">Berat Badan</span>
                <div class="text-3xl font-black text-emerald-800 mt-1">{{ $stunting->berat_badan }} kg</div>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl text-center">
                <span class="text-xs text-slate-500 font-bold uppercase">Tinggi / Panjang Badan</span>
                <div class="text-3xl font-black text-emerald-800 mt-1">{{ $stunting->tinggi_badan }} cm</div>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl text-center">
                <span class="text-xs text-slate-500 font-bold uppercase">Lingkar Kepala</span>
                <div class="text-3xl font-black text-emerald-800 mt-1">{{ $stunting->lingkar_kepala ?? '-' }} cm</div>
            </div>
        </div>

        <!-- Identitas Keluarga -->
        <div class="border-t border-slate-100 pt-6">
            <h3 class="text-lg font-black text-slate-900 mb-4">
                👨‍👩‍👧 Data Orang Tua & Domisili
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div><strong>Nama Ibu:</strong> {{ $stunting->nama_ibu }}</div>
                <div><strong>Nama Ayah:</strong> {{ $stunting->nama_ayah }}</div>
                <div><strong>Wilayah:</strong> RT {{ $stunting->rt }} / RW {{ $stunting->rw }}</div>
                <div><strong>NIK Anak:</strong> {{ $stunting->masked_nik_anak }}</div>
            </div>
        </div>

        <!-- Intervensi PMT & Catatan Kader -->
        <div class="border-t border-slate-100 pt-6 space-y-3">
            <div class="p-4 bg-blue-50 rounded-2xl border border-blue-200">
                <h4 class="font-bold text-blue-950 text-sm mb-1">🍎 Intervensi / Pemberian Makanan Tambahan:</h4>
                <p class="text-sm text-blue-900">{{ $stunting->intervensi_diberikan ?? 'Pemberian gizi standar Posyandu' }}</p>
            </div>

            @if($stunting->catatan_kader)
                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200">
                    <h4 class="font-bold text-amber-950 text-sm mb-1">📝 Catatan Kader Posyandu:</h4>
                    <p class="text-sm text-amber-900">{{ $stunting->catatan_kader }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
