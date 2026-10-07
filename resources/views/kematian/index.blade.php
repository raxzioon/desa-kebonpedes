@extends('layouts.app')

@section('title', 'Pencatatan Warga Meninggal - ' . config('desa.nama_desa'))
@section('page_title', 'Pencatatan Kematian')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <span class="px-3.5 py-1 bg-rose-100 text-rose-900 font-bold text-xs rounded-full uppercase tracking-wider inline-block mb-2">
                🕊️ Administrasi Warga Meninggal
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                Pencatatan & Surat Kematian Warga
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Pencatatan akta/surat keterangan kematian warga yang sah dan terverifikasi oleh Kepala Desa.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('kematian.create') }}" class="btn-touch px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="text-xl">➕</span> Catat Warga Meninggal
            </a>
        </div>
    </div>

    <!-- Tabel Data Kematian -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-base">
                <thead>
                    <tr class="border-b-2 border-slate-200 bg-slate-50 text-slate-800 font-bold">
                        <th class="py-4 px-5">Nama Almarhum / Almarhumah</th>
                        <th class="py-4 px-4">Waktu & Tempat</th>
                        <th class="py-4 px-4">Sebab Kematian</th>
                        <th class="py-4 px-4">Pelapor / Ahli Waris</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kematians as $k)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-5">
                                <div class="font-black text-slate-900 text-lg">{{ $k->penduduk->nama ?? 'Warga' }}</div>
                                <div class="text-xs text-slate-500 font-mono">NIK: {{ $k->penduduk->masked_nik ?? '-' }}</div>
                                <div class="text-xs text-slate-500">RT {{ $k->penduduk->rt ?? '-' }} / RW {{ $k->penduduk->rw ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 text-sm">{{ $k->tanggal_kematian->translatedFormat('d F Y') }}</div>
                                <div class="text-xs text-slate-500">Pukul: {{ $k->waktu_kematian ?? '-' }}</div>
                                <div class="text-xs text-slate-600 font-semibold">{{ $k->tempat_kematian }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm font-semibold text-slate-800">{{ $k->sebab_kematian }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 text-sm">{{ $k->nama_pelapor }}</div>
                                <div class="text-xs text-slate-500">{{ $k->hubungan_pelapor }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-black border {{ $k->status_badge['class'] }}">
                                    {{ $k->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-right">
                                @if($k->status_pengajuan === 'menunggu' && $user->isKades())
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('kematian.approve', $k->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Konfirmasi pencatatan kematian warga dan update status dasar?')" class="btn-touch px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow transition">
                                                ✅ Konfirmasi
                                            </button>
                                        </form>
                                        <form action="{{ route('kematian.reject', $k->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Tolak laporan kematian ini?')" class="btn-touch px-3 py-2 bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold text-xs rounded-xl border border-rose-300 transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($k->status_pengajuan === 'disetujui')
                                    <span class="text-xs font-bold text-emerald-700 flex items-center justify-end gap-1">
                                        <span>✔️</span> Terverifikasi Sah
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-slate-400">{{ ucfirst($k->status_pengajuan) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <span class="text-4xl block mb-2">🕊️</span>
                                <h3 class="text-lg font-bold text-slate-800">Belum ada catatan warga meninggal</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-slate-100 bg-slate-50">
            {{ $kematians->links() }}
        </div>
    </div>
</div>
@endsection
