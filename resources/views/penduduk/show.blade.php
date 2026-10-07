@extends('layouts.app')

@section('title', 'Biodata Warga: ' . $penduduk->nama . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Biodata Warga')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <a href="{{ route('penduduk.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
                &larr; Kembali ke Daftar Warga
            </a>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-1">
                {{ $penduduk->nama }}
            </h1>
            <p class="text-sm text-slate-600 font-mono">
                NIK: <strong class="text-emerald-800">{{ $penduduk->nik }}</strong> (Dokumen Resmi)
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="btn-touch px-4 py-2.5 bg-slate-800 hover:bg-black text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-2">
                <span>🖨️</span> Cetak Biodata
            </button>
            <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn-touch px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-2">
                <span>✏️</span> Ubah Data
            </a>
        </div>
    </div>

    <!-- Kartu Biodata Lengkap -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border-2 border-slate-200 shadow-md space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Nomor Kartu Keluarga (KK)</span>
                <p class="font-mono font-black text-lg text-slate-900 mt-0.5">{{ $penduduk->no_kk }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Status Kependudukan</span>
                <p class="font-black text-lg text-emerald-800 mt-0.5 uppercase">{{ $penduduk->status_dasar }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Jenis Kelamin</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Tempat, Tanggal Lahir</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->tempat_lahir }}, {{ $penduduk->tanggal_lahir->translatedFormat('d F Y') }} ({{ $penduduk->usia }} Tahun)</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Agama</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->agama }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Golongan Darah</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->golongan_darah }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Pendidikan Terakhir</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->pendidikan }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Pekerjaan</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->pekerjaan }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Status Pernikahan</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">{{ $penduduk->status_pernikahan }}</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Wilayah Domisili</span>
                <p class="font-bold text-lg text-slate-900 mt-0.5">RT {{ $penduduk->rt }} / RW {{ $penduduk->rw }}</p>
            </div>

            <div class="sm:col-span-2 p-4 bg-slate-50 rounded-2xl">
                <span class="text-xs text-slate-500 font-bold uppercase">Alamat Lengkap</span>
                <p class="font-bold text-base text-slate-900 mt-0.5">{{ $penduduk->alamat }}</p>
            </div>
        </div>

        <!-- Info Log & Etika PDP -->
        <div class="border-t-2 border-slate-100 pt-4 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-500 gap-2">
            <div>
                <span>Persetujuan Warga (Opt-In PDP): <strong class="text-emerald-700">Tercatat Sah</strong> ({{ $penduduk->opt_in_at?->translatedFormat('d M Y H:i') ?? '-' }})</span>
            </div>
            <div>
                <span>Didaftarkan oleh: {{ $penduduk->createdBy->name ?? 'Aparatur Desa' }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
