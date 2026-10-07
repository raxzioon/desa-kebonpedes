@extends('layouts.app')

@section('title', 'Riwayat Audit Log Sistem - ' . config('desa.nama_desa'))
@section('page_title', 'Audit Log Desa')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <span class="px-3.5 py-1 bg-purple-100 text-purple-900 font-bold text-xs rounded-full uppercase tracking-wider inline-block mb-2">
                📜 Transparansi & Akuntabilitas
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                Riwayat Audit Log & Jejak Aktivitas
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Catatan otomatis seluruh aktivitas aparatur desa untuk menjamin integritas data sesuai etika profesi.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}" class="btn-touch px-5 py-2.5 bg-slate-900 hover:bg-black text-white font-bold text-sm rounded-xl transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('audit-log.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Cari Keterangan / Pengguna:</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik kata kunci..." class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Modul:</label>
                <select name="modul" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300">
                    <option value="">-- Semua Modul --</option>
                    @foreach($moduls as $m)
                        <option value="{{ $m }}" {{ request('modul') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Aksi:</label>
                <select name="aksi" class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-300">
                    <option value="">-- Semua Aksi --</option>
                    @foreach($aksis as $a)
                        <option value="{{ $a }}" {{ request('aksi') == $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn-touch w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl">
                    Filter
                </button>
                <a href="{{ route('audit-log.index') }}" class="btn-touch px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-200 bg-slate-50 text-slate-700">
                        <th class="py-3 px-4 font-bold">Waktu</th>
                        <th class="py-3 px-4 font-bold">Pengguna & Peran</th>
                        <th class="py-3 px-4 font-bold">Aksi</th>
                        <th class="py-3 px-4 font-bold">Modul</th>
                        <th class="py-3 px-4 font-bold">Deskripsi Aktivitas</th>
                        <th class="py-3 px-4 font-bold">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($auditLogs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-mono text-xs text-slate-500 whitespace-nowrap">
                                {{ $log->created_at->translatedFormat('d M Y H:i:s') }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900">{{ $log->user_name }}</div>
                                <div class="text-xs text-slate-500">{{ $log->user_role }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-800 rounded-md font-mono text-xs font-bold border border-slate-300">
                                    {{ $log->aksi }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-emerald-800">{{ $log->modul }}</td>
                            <td class="py-3 px-4 text-slate-700 text-xs leading-relaxed">{{ $log->deskripsi }}</td>
                            <td class="py-3 px-4 font-mono text-xs text-slate-400">{{ $log->ip_address ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">Belum ada riwayat aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $auditLogs->links() }}
        </div>
    </div>
</div>
@endsection
