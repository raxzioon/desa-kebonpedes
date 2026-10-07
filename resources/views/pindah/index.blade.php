@extends('layouts.app')

@section('title', 'Layanan Pindah Kampung - ' . config('desa.nama_desa'))
@section('page_title', 'Layanan Pindah Warga')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <span class="px-3.5 py-1 bg-blue-100 text-blue-900 font-bold text-xs rounded-full uppercase tracking-wider inline-block mb-2">
                📦 Mutasi Kependudukan Keluar
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                Pengajuan Surat Pindah Kampung
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Alur pengajuan surat pengantar pindah: Diajukan oleh RT &rarr; Disetujui Kepala Desa &rarr; Status warga diperbarui.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('pindah.create') }}" class="btn-touch px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="text-xl">➕</span> Ajukan Surat Pindah Baru
            </a>
        </div>
    </div>

    <!-- Tabel Pengajuan Pindah -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-base">
                <thead>
                    <tr class="border-b-2 border-slate-200 bg-slate-50 text-slate-800 font-bold">
                        <th class="py-4 px-5">No. Pengantar & Warga</th>
                        <th class="py-4 px-4">Tujuan Kepindahan</th>
                        <th class="py-4 px-4">Alasan & Tgl</th>
                        <th class="py-4 px-4">Status Alur</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pindahs as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-5">
                                <div class="font-mono text-xs text-slate-500 font-bold">{{ $p->no_surat_pengantar }}</div>
                                <div class="font-black text-slate-900 text-lg mt-0.5">{{ $p->penduduk->nama ?? 'Warga Terdaftar' }}</div>
                                <div class="text-xs text-slate-500">Asal: RT {{ $p->penduduk->rt ?? '-' }} / RW {{ $p->penduduk->rw ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 text-sm">{{ $p->desa_kelurahan_tujuan }}, {{ $p->kecamatan_tujuan }}</div>
                                <div class="text-xs text-slate-500">{{ $p->kabupaten_kota_tujuan }}, {{ $p->provinsi_tujuan }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-semibold text-slate-800 text-sm">{{ $p->alasan_pindah }}</div>
                                <div class="text-xs text-slate-500">Tgl: {{ $p->tanggal_pindah->format('d/m/Y') }} ({{ $p->jumlah_keluarga_pindah }} Orang)</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-black border {{ $p->status_badge['class'] }}">
                                    {{ $p->status_badge['label'] }}
                                </span>
                                @if($p->catatan_kades)
                                    <div class="text-xs text-slate-500 italic mt-1">"{{ $p->catatan_kades }}"</div>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                @if($p->status_pengajuan === 'menunggu' && $user->isKades())
                                    <div class="inline-flex items-center gap-2">
                                        <form action="{{ route('pindah.approve', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Setujui surat pengantar pindah ini?')" class="btn-touch px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow transition">
                                                ✅ Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('pindah.reject', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Tolak permohonan pindah ini?')" class="btn-touch px-3 py-2 bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold text-xs rounded-xl border border-rose-300 transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($p->status_pengajuan === 'disetujui')
                                    <span class="text-xs font-bold text-emerald-700 flex items-center justify-end gap-1">
                                        <span>✔️</span> Selesai ({{ $p->disetujui_at?->format('d/m/Y') }})
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-slate-400">
                                        {{ ucfirst($p->status_pengajuan) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-500">
                                <span class="text-4xl block mb-2">📦</span>
                                <h3 class="text-lg font-bold text-slate-800">Belum ada riwayat permohonan pindah</h3>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-slate-100 bg-slate-50">
            {{ $pindahs->links() }}
        </div>
    </div>
</div>
@endsection
