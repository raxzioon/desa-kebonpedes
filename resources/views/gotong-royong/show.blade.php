@extends('layouts.app')

@section('title', $kegiatan->judul . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Rincian Kegiatan Gotong Royong')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="mb-6">
        <a href="{{ route('gotong-royong.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Papan Gotong Royong
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- KOLOM KIRI: DETAIL KEGIATAN & DAFTAR RELAWAN -->
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-900 font-bold text-xs rounded-full">
                        {{ $kegiatan->kategori }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $kegiatan->status_badge['class'] }}">
                        {{ $kegiatan->status_badge['label'] }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight leading-tight mb-4">
                    {{ $kegiatan->judul }}
                </h1>

                <p class="text-base text-slate-700 leading-relaxed mb-6">
                    {{ $kegiatan->deskripsi }}
                </p>

                <div class="space-y-3 bg-slate-50 p-5 rounded-2xl border border-slate-200 text-sm text-slate-800">
                    <div><strong>📅 Tanggal:</strong> {{ $kegiatan->tanggal_kegiatan->translatedFormat('l, d F Y') }}</div>
                    <div><strong>⏰ Waktu:</strong> {{ $kegiatan->jam_kegiatan }}</div>
                    <div><strong>📍 Lokasi:</strong> {{ $kegiatan->lokasi }}</div>
                    <div><strong>👤 Penanggung Jawab:</strong> {{ $kegiatan->kontak_pj }} ({{ $kegiatan->no_wa_pj }})</div>
                </div>
            </div>

            <!-- Daftar Relawan yang Sudah Mendaftar -->
            <div class="bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-md">
                <h3 class="text-xl font-black text-slate-900 mb-1 flex items-center justify-between">
                    <span>👥 Relawan yang Bergabung</span>
                    <span class="text-sm font-bold text-emerald-700">{{ $kegiatan->relawans->count() }} Orang</span>
                </h3>
                <p class="text-xs text-slate-500 mb-6">Warga desa yang telah mendaftarkan diri secara sukarela</p>

                <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto pr-2">
                    @forelse($kegiatan->relawans as $r)
                        <div class="py-3 flex items-start justify-between gap-4">
                            <div>
                                <div class="font-bold text-slate-900">{{ $r->nama_relawan }}</div>
                                <div class="text-xs text-slate-500">Warga RT {{ $r->rt }} / RW {{ $r->rw }}</div>
                                @if($r->pesan_dukungan)
                                    <p class="text-xs text-slate-600 italic mt-1">"{{ $r->pesan_dukungan }}"</p>
                                @endif
                            </div>
                            <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold shrink-0">
                                {{ $r->status_kehadiran }}
                            </span>
                        </div>
                    @empty
                        <div class="py-6 text-center text-slate-500 text-sm">
                            Belum ada relawan terdaftar. Jadilah yang pertama mendaftar!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: FORMULIR PENDAFTARAN RELAWAN -->
        <div class="lg:col-span-5 bg-gradient-to-br from-emerald-50 via-teal-50 to-emerald-100 p-6 sm:p-8 rounded-3xl border-2 border-emerald-300 shadow-xl sticky top-28">
            <h3 class="text-2xl font-black text-emerald-950 mb-2 flex items-center gap-2">
                <span>✍️</span> Formulir Jadi Relawan
            </h3>
            <p class="text-sm text-emerald-900 mb-6 leading-relaxed">
                Mari bersama berkontribusi untuk desa tercinta. Isi formulir singkat di bawah ini:
            </p>

            <form method="POST" action="{{ route('gotong-royong.daftar-relawan', $kegiatan->id) }}" class="space-y-4">
                @csrf

                <div>
                    <label for="nama_relawan" class="block font-bold text-slate-800 text-sm mb-1">
                        Nama Lengkap Anda: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_relawan" id="nama_relawan" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-emerald-300 bg-white focus:border-emerald-700">
                </div>

                <div>
                    <label for="no_wa" class="block font-bold text-slate-800 text-sm mb-1">
                        Nomor WhatsApp: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="no_wa" id="no_wa" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-emerald-300 bg-white focus:border-emerald-700 font-mono">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="rt" class="block font-bold text-slate-800 text-sm mb-1">RT:</label>
                        <select name="rt" id="rt" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-emerald-300 bg-white font-bold">
                            <option value="01">RT 01</option>
                            <option value="02">RT 02</option>
                            <option value="03">RT 03</option>
                        </select>
                    </div>

                    <div>
                        <label for="rw" class="block font-bold text-slate-800 text-sm mb-1">RW:</label>
                        <select name="rw" id="rw" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-emerald-300 bg-white font-bold">
                            <option value="01">RW 01</option>
                            <option value="02">RW 02</option>
                            <option value="03">RW 03</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="pesan_dukungan" class="block font-bold text-slate-800 text-sm mb-1">Pesan Semangat (Opsional):</label>
                    <textarea name="pesan_dukungan" id="pesan_dukungan" rows="2" placeholder="Contoh: Siap hadir bawa cangkul dan semangat!" class="w-full px-4 py-2.5 text-sm rounded-2xl border-2 border-emerald-300 bg-white"></textarea>
                </div>

                <button type="submit" class="btn-touch w-full py-4 px-6 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl transition transform active:scale-95 flex items-center justify-center gap-2 mt-4">
                    <span>🤝 Daftarkan Diri Sekarang</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
