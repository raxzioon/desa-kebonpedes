@extends('layouts.app')

@section('title', 'Data Balita & Stunting - ' . config('desa.nama_desa'))
@section('page_title', 'Data Stunting & Balita')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1 bg-amber-100 text-amber-900 font-bold text-xs rounded-full uppercase tracking-wider">
                    👶 Kesehatan Ibu & Anak
                </span>
                <span class="px-3 py-0.5 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full">
                    Pencegahan Stunting (SDG 2 & 3)
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-1">
                Data Pemantauan Gizi & Tumbuh Kembang Balita
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Pencatatan penimbangan berat badan, tinggi badan, dan intervensi makanan tambahan di Posyandu {{ config('desa.nama_desa') }}.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('stunting.create') }}" class="btn-touch px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="text-xl">➕</span> Catat Pemeriksaan Balita
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('stunting.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <div class="sm:col-span-5">
                <label for="sq" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    🔍 Cari Nama Anak / Nama Ibu / Posyandu:
                </label>
                <input type="text" name="q" id="sq" value="{{ request('q') }}" placeholder="Ketik nama balita atau ibu..." class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600">
            </div>

            <div class="sm:col-span-4">
                <label for="filter_stunting" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Status Stunting:
                </label>
                <select name="status_stunting" id="filter_stunting" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                    <option value="">-- Semua Status --</option>
                    <option value="Normal" {{ request('status_stunting') == 'Normal' ? 'selected' : '' }}>Tinggi Normal & Sehat</option>
                    <option value="Pendek (Stunted)" {{ request('status_stunting') == 'Pendek (Stunted)' ? 'selected' : '' }}>Pendek (Stunted)</option>
                    <option value="Sangat Pendek (Severely Stunted)" {{ request('status_stunting') == 'Sangat Pendek (Severely Stunted)' ? 'selected' : '' }}>Sangat Pendek (Severe)</option>
                    <option value="Tinggi" {{ request('status_stunting') == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <div class="sm:col-span-3 flex gap-2">
                <button type="submit" class="btn-touch w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-base rounded-2xl shadow">
                    Filter Data
                </button>
                <a href="{{ route('stunting.index') }}" class="btn-touch px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-base rounded-2xl border border-slate-300">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Data Balita & Status Gizi -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-base">
                <thead>
                    <tr class="border-b-2 border-slate-200 bg-slate-50 text-slate-800 font-bold">
                        <th class="py-4 px-5">Nama Balita & Orang Tua</th>
                        <th class="py-4 px-4">L/P & Usia</th>
                        <th class="py-4 px-4">Hasil Ukur (BB / TB)</th>
                        <th class="py-4 px-4">Status Stunting & Gizi</th>
                        <th class="py-4 px-4">Posyandu & Tgl Cek</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stuntings as $s)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="py-4 px-5">
                                <div class="font-black text-slate-900 text-lg">{{ $s->nama_anak }}</div>
                                <div class="text-xs text-slate-600 mt-0.5">
                                    Ibu: <strong class="text-slate-800">{{ $s->nama_ibu }}</strong> &bull; Bpk: {{ $s->nama_ayah }}
                                </div>
                                <div class="text-xs text-slate-400">RT {{ $s->rt }} / RW {{ $s->rw }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 rounded text-xs font-bold {{ $s->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $s->jenis_kelamin === 'L' ? 'L' : 'P' }}
                                </span>
                                <div class="font-bold text-slate-800 mt-1 text-sm">{{ $s->usia_bulan }} Bulan</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900">{{ $s->berat_badan }} kg</div>
                                <div class="text-sm font-semibold text-emerald-800">{{ $s->tinggi_badan }} cm</div>
                                @if($s->lingkar_kepala)
                                    <div class="text-xs text-slate-400">LK: {{ $s->lingkar_kepala }} cm</div>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-black border {{ $s->status_badge['class'] }}">
                                    {{ $s->status_stunting }}
                                </span>
                                <div class="text-xs text-slate-500 font-semibold mt-1">Gizi: {{ $s->status_gizi }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 text-sm">{{ $s->posyandu_nama }}</div>
                                <div class="text-xs text-slate-500">{{ $s->tanggal_pemeriksaan->format('d/m/Y') }}</div>
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('stunting.show', $s->id) }}" class="btn-touch px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition" title="Lihat Rincian">
                                        👁️ Detail
                                    </a>
                                    <a href="{{ route('stunting.edit', $s->id) }}" class="btn-touch px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs rounded-xl border border-emerald-200 transition" title="Ubah Pemeriksaan">
                                        ✏️ Ubah
                                    </a>
                                    <form action="{{ route('stunting.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus riwayat balita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-touch px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl border border-rose-200 transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <span class="text-4xl block mb-2">👶</span>
                                <h3 class="text-lg font-bold text-slate-800">Tidak ada data pemeriksaan balita</h3>
                                <p class="text-sm text-slate-500">Silakan tambahkan data melalui tombol "+ Catat Pemeriksaan Balita".</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-slate-100 bg-slate-50">
            {{ $stuntings->links() }}
        </div>
    </div>
</div>
@endsection
