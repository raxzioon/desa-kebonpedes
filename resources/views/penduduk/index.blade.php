@extends('layouts.app')

@section('title', 'Data Penduduk - ' . config('desa.nama_desa'))
@section('page_title', 'Data Penduduk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Modul -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3.5 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs rounded-full uppercase tracking-wider">
                    👥 Administrasi Kependudukan
                </span>
                <span class="px-3 py-0.5 bg-slate-200 text-slate-800 text-xs font-bold rounded-full">
                    Wilayah: {{ $user->isKades() ? 'Seluruh Desa' : 'RT ' . $user->rt . ' / RW ' . $user->rw }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-1">
                Data Warga {{ config('desa.nama_desa') }}
            </h1>
            <p class="text-sm text-slate-600 mt-1">
                Pengelolaan biodata kependudukan dengan perlindungan data pribadi dan pembatasan wilayah RT/RW.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('penduduk.create') }}" class="btn-touch px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-base rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2">
                <span class="text-xl">➕</span> Tambah Warga Baru
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Ramah Pengguna -->
    <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-sm mb-6">
        <form method="GET" action="{{ route('penduduk.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
            <!-- Pencarian Kata Kunci -->
            <div class="sm:col-span-5">
                <label for="search_q" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    🔍 Cari Nama, NIK, No. KK, atau Alamat:
                </label>
                <input type="text" name="q" id="search_q" value="{{ request('q') }}" placeholder="Ketik nama atau kata kunci..." class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 outline-none transition">
            </div>

            <!-- Filter RT (Hanya jika Kades) -->
            @if($user->isKades())
                <div class="sm:col-span-3">
                    <label for="filter_rt" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Filter Wilayah RT:
                    </label>
                    <select name="rt" id="filter_rt" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 outline-none transition bg-white">
                        <option value="">-- Semua RT --</option>
                        <option value="01" {{ request('rt') == '01' ? 'selected' : '' }}>RT 01</option>
                        <option value="02" {{ request('rt') == '02' ? 'selected' : '' }}>RT 02</option>
                        <option value="03" {{ request('rt') == '03' ? 'selected' : '' }}>RT 03</option>
                    </select>
                </div>
            @endif

            <!-- Filter Status Dasar -->
            <div class="{{ $user->isKades() ? 'sm:col-span-2' : 'sm:col-span-4' }}">
                <label for="filter_status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Status Dasar:
                </label>
                <select name="status_dasar" id="filter_status" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 outline-none transition bg-white">
                    <option value="hidup" {{ request('status_dasar', 'hidup') == 'hidup' ? 'selected' : '' }}>Hidup (Aktif)</option>
                    <option value="pindah" {{ request('status_dasar') == 'pindah' ? 'selected' : '' }}>Pindah Keluar</option>
                    <option value="meninggal" {{ request('status_dasar') == 'meninggal' ? 'selected' : '' }}>Meninggal Dunia</option>
                </select>
            </div>

            <!-- Tombol Aksi Filter -->
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="btn-touch w-full py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-base rounded-2xl shadow transition">
                    Cari
                </button>
                <a href="{{ route('penduduk.index') }}" class="btn-touch px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-base rounded-2xl border border-slate-300 transition" title="Reset Pencarian">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Catatan Etika & Kerahasiaan NIK -->
    <div class="mb-4 p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-xs text-emerald-900 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xl">🔒</span>
            <span><strong>Perlindungan Data Pribadi:</strong> NIK disamarkan (<em>masking</em>) untuk melindungi kerahasiaan identitas warga. Klik tombol <strong>"Lihat Detail"</strong> untuk verifikasi dokumen resmi.</span>
        </div>
        <span class="text-emerald-700 font-bold shrink-0">Total: {{ $penduduks->total() }} Warga</span>
    </div>

    <!-- Tabel Data Penduduk -->
    <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-base">
                <thead>
                    <tr class="border-b-2 border-slate-200 bg-slate-50 text-slate-800 font-bold">
                        <th class="py-4 px-5">Nama Lengkap & NIK</th>
                        <th class="py-4 px-4">L/P</th>
                        <th class="py-4 px-4">Usia & Tgl Lahir</th>
                        <th class="py-4 px-4">Alamat / RT</th>
                        <th class="py-4 px-4">Pekerjaan</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penduduks as $p)
                        <tr class="hover:bg-emerald-50/40 transition">
                            <td class="py-4 px-5">
                                <div class="font-black text-slate-900 text-lg">{{ $p->nama }}</div>
                                <div class="text-xs font-mono text-slate-500 flex items-center gap-1.5 mt-0.5">
                                    <span class="px-1.5 py-0.5 bg-slate-100 text-slate-700 rounded font-bold">NIK:</span>
                                    <span class="font-bold text-slate-700">{{ $p->masked_nik }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $p->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800">{{ $p->usia }} Tahun</div>
                                <div class="text-xs text-slate-500">{{ $p->tanggal_lahir->format('d/m/Y') }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="font-semibold text-slate-800 text-sm">RT {{ $p->rt }} / RW {{ $p->rw }}</div>
                                <div class="text-xs text-slate-500 line-clamp-1">{{ $p->alamat }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm font-semibold text-slate-800">{{ $p->pekerjaan }}</div>
                                <div class="text-xs text-slate-500">{{ $p->pendidikan }}</div>
                            </td>
                            <td class="py-4 px-4">
                                @if($p->status_dasar === 'hidup')
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs rounded-full">
                                        Hidup
                                    </span>
                                @elseif($p->status_dasar === 'pindah')
                                    <span class="px-2.5 py-1 bg-blue-100 text-blue-800 font-bold text-xs rounded-full">
                                        Pindah
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-rose-100 text-rose-800 font-bold text-xs rounded-full">
                                        Meninggal
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('penduduk.show', $p->id) }}" class="btn-touch px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition" title="Lihat Profil Lengkap">
                                        👁️ Detail
                                    </a>
                                    <a href="{{ route('penduduk.edit', $p->id) }}" class="btn-touch px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs rounded-xl border border-emerald-200 transition" title="Ubah Data">
                                        ✏️ Ubah
                                    </a>
                                    <form action="{{ route('penduduk.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus data warga \'{{ $p->nama }}\'? Aksi ini akan dicatat dalam Audit Log.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-touch px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs rounded-xl border border-rose-200 transition" title="Hapus Data">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <span class="text-4xl block mb-2">🔍</span>
                                <h3 class="text-lg font-bold text-slate-800">Tidak ada data warga yang sesuai</h3>
                                <p class="text-sm text-slate-500">Coba ubah kata kunci pencarian atau filter RT Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t-2 border-slate-100 bg-slate-50">
            {{ $penduduks->links() }}
        </div>
    </div>
</div>
@endsection
