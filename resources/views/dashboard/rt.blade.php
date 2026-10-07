@extends('layouts.app')

@section('title', 'Dashboard ' . $user->role_label . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Dashboard RT/RW')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Sambutan RT -->
    <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="px-3.5 py-1 bg-blue-500/30 border border-blue-300/30 text-blue-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-2">
                🏡 Hak Akses Wilayah: {{ $user->role_label }}
            </span>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight">
                Selamat Bertugas, Bapak {{ $user->name }}
            </h1>
            <p class="text-blue-100 text-base mt-1">
                Wilayah Pengelolaan: <strong>RT {{ $user->rt ?? '01' }} / RW {{ $user->rw ?? '01' }}</strong> &bull; {{ config('desa.nama_desa') }}
            </p>
        </div>

        <div class="flex flex-wrap gap-3 shrink-0">
            <a href="{{ route('penduduk.create') }}" class="btn-touch px-5 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm rounded-2xl shadow-lg transition flex items-center gap-2">
                <span>➕</span> Tambah Warga Baru
            </a>
            <a href="{{ route('pindah.create') }}" class="btn-touch px-4 py-3 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-2xl border border-white/30 backdrop-blur-sm transition">
                📦 Lapor Pindah Warga
            </a>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 1. KARTU STATISTIK WILAYAH RT (SCOPED STATS) -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-blue-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Warga RT {{ $user->rt }}</span>
                <span class="text-2xl">👥</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-slate-900">{{ $totalPendudukRt }}</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                {{ $totalLakiRt }} Laki-laki &bull; {{ $totalPerempuanRt }} Perempuan
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-blue-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Kepala Keluarga (KK)</span>
                <span class="text-2xl">🏡</span>
            </div>
            <div class="text-4xl md:text-5xl font-black text-slate-900">{{ $totalKkRt }}</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                Rumah Tangga di RT {{ $user->rt }}
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-md border-2 {{ $antreanKtpRt->count() > 0 ? 'border-amber-300 bg-amber-50/50' : 'border-slate-100' }}">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Verifikasi Surat KTP</span>
                <span class="text-2xl">⏳</span>
            </div>
            <div class="text-4xl md:text-5xl font-black {{ $antreanKtpRt->count() > 0 ? 'text-amber-600' : 'text-slate-900' }}">{{ $antreanKtpRt->count() }}</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                Permohonan Warga RT {{ $user->rt }}
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-md border-2 border-emerald-100">
            <div class="flex items-center justify-between text-slate-500 text-sm font-bold mb-1">
                <span>Status Data RT</span>
                <span class="text-2xl">✅</span>
            </div>
            <div class="text-xl md:text-2xl font-black text-emerald-700 mt-1">Terverifikasi</div>
            <div class="text-xs text-slate-500 mt-2 font-semibold">
                Persetujuan PDP Aktif
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 2. ANTREAN VERIFIKASI KTP HILANG OLEH KETUA RT -->
    <!-- ========================================================= -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md p-6 sm:p-8 mb-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <div>
                <h2 class="text-2xl font-black text-slate-900 flex items-center gap-2">
                    <span>🆔</span> Permohonan Surat KTP Hilang (Warga RT {{ $user->rt }})
                </h2>
                <p class="text-sm text-slate-600">
                    Verifikasi bahwa pemohon benar-benar warga sah RT Anda sebelum diteruskan ke Kepala Desa.
                </p>
            </div>
            <span class="px-3.5 py-1 bg-amber-100 text-amber-900 font-bold text-xs rounded-full border border-amber-300">
                {{ $antreanKtpRt->count() }} Menunggu Verifikasi
            </span>
        </div>

        @if($antreanKtpRt->isEmpty())
            <div class="text-center py-8 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <span class="text-4xl block mb-2">🌿</span>
                <h3 class="text-base font-bold text-slate-800">Tidak ada pengajuan KTP hilang baru dari warga RT {{ $user->rt }}</h3>
                <p class="text-xs text-slate-500">Semua permohonan warga telah selesai diverifikasi.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($antreanKtpRt as $ktp)
                    <div class="p-5 rounded-2xl bg-amber-50/70 border-2 border-amber-300 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 bg-amber-200 text-amber-900 text-xs font-black rounded-md font-mono">{{ $ktp->kode_lacak }}</span>
                                <span class="text-xs text-slate-500 font-semibold">Tgl Hilang: {{ $ktp->tanggal_kehilangan->format('d/m/Y') }}</span>
                            </div>
                            <h4 class="font-black text-lg text-slate-900">{{ $ktp->nama_pemohon }} (NIK: {{ $ktp->masked_nik }})</h4>
                            <p class="text-sm text-slate-700">
                                <strong>Alamat:</strong> {{ $ktp->alamat }} &bull; <strong>No. HP:</strong> {{ $ktp->no_hp }}
                            </p>
                            <p class="text-xs text-slate-600 italic">"{{ $ktp->kronologi }}"</p>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <form action="{{ route('ktp-hilang.rt-verify', $ktp->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Verifikasi bahwa warga ini sah berdomisili di RT Anda dan berkas sesuai?')" class="btn-touch px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow transition flex items-center gap-1">
                                    <span>✅</span> Verifikasi & Teruskan ke Kades
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ========================================================= -->
    <!-- 3. DAFTAR WARGA TERBARU DI RT -->
    <!-- ========================================================= -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-slate-100">
            <div>
                <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                    <span>👥</span> Data Warga Terkini di RT {{ $user->rt }} / RW {{ $user->rw }}
                </h3>
                <p class="text-xs text-slate-500">Dibatasi hanya untuk wilayah kekuasaan Anda sesuai prinsip perlindungan data</p>
            </div>
            <a href="{{ route('penduduk.index') }}" class="text-sm font-bold text-blue-700 hover:underline">
                Lihat Semua Warga RT {{ $user->rt }} &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-200 text-slate-700 bg-slate-50">
                        <th class="py-3 px-4 font-bold">Nama Warga</th>
                        <th class="py-3 px-4 font-bold">NIK (Disamarkan)</th>
                        <th class="py-3 px-4 font-bold">L/P</th>
                        <th class="py-3 px-4 font-bold">Usia</th>
                        <th class="py-3 px-4 font-bold">Pekerjaan</th>
                        <th class="py-3 px-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($wargaTerbaru as $w)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3 px-4 font-black text-slate-900">{{ $w->nama }}</td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $w->masked_nik }}</td>
                            <td class="py-3 px-4">{{ $w->jenis_kelamin }}</td>
                            <td class="py-3 px-4">{{ $w->usia }} Th</td>
                            <td class="py-3 px-4">{{ $w->pekerjaan }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('penduduk.show', $w->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-lg text-xs">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
