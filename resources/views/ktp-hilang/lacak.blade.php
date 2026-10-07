@extends('layouts.app')

@section('title', 'Lacak Status Surat KTP Hilang - ' . config('desa.nama_desa'))
@section('page_title', 'Lacak Status Surat')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center max-w-2xl mx-auto mb-10">
        <span class="px-4 py-1.5 bg-blue-100 text-blue-900 font-bold text-xs rounded-full uppercase tracking-wider inline-block mb-3">
            🔍 Pelacakan Status Berkas Mandiri
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mb-3">
            Lacak Surat KTP Hilang Anda
        </h1>
        <p class="text-base text-slate-600 leading-relaxed">
            Pantau tahapan verifikasi berkas secara langsung seperti melacak pengiriman paket.
        </p>
    </div>

    <!-- Form Pencarian Kode Lacak -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md mb-8">
        <form action="{{ route('ktp-hilang.lacak') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <label for="kode_lacak" class="sr-only">Kode Lacak</label>
                <input type="text" name="kode_lacak" id="kode_lacak" value="{{ request('kode_lacak', $kodeInput) }}" required placeholder="Masukkan Kode Lacak (Contoh: KTP-202610-C99Z)" class="w-full px-5 py-4 text-lg font-mono font-bold uppercase rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 bg-slate-50">
            </div>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-lg transition">
                🔍 Cek Status
            </button>
        </form>
    </div>

    <!-- Hasil Pelacakan -->
    @if($hasilLacak)
        <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-xl overflow-hidden mb-8">
            <!-- Header Kartu Pelacakan -->
            <div class="bg-gradient-to-r from-slate-900 to-emerald-950 text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">Kode Pelacakan Resmi:</span>
                    <h2 class="text-2xl sm:text-3xl font-black font-mono tracking-tight mt-0.5">{{ $hasilLacak->kode_lacak }}</h2>
                    <p class="text-sm text-slate-300 mt-1">Pemohon: <strong>{{ $hasilLacak->nama_pemohon }}</strong> (NIK: {{ $hasilLacak->masked_nik }})</p>
                </div>

                <div class="shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full font-black text-sm border {{ $hasilLacak->status_badge['class'] }}">
                        <span>{{ $hasilLacak->status_badge['text'] }}</span>
                    </span>
                </div>
            </div>

            <!-- ========================================================= -->
            <!-- 4-STEP VISUAL PROGRESS STEPPER (ALA LACAK PAKET) -->
            <!-- ========================================================= -->
            <div class="p-6 sm:p-8 border-b-2 border-slate-100 bg-slate-50/50">
                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-6">
                    Tahapan Alur Pelayanan:
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">
                    <!-- Step 1: Diajukan -->
                    <div class="p-4 rounded-2xl border-2 {{ $hasilLacak->status_step >= 1 ? 'bg-emerald-50 border-emerald-400 text-emerald-950' : 'bg-white border-slate-200 text-slate-400' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-full {{ $hasilLacak->status_step >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center font-bold text-sm">
                                1
                            </span>
                            @if($hasilLacak->status_step >= 1)
                                <span class="text-emerald-600 text-lg font-bold">✓</span>
                            @endif
                        </div>
                        <h4 class="font-black text-base">1. Pengajuan Warga</h4>
                        <p class="text-xs mt-1 {{ $hasilLacak->status_step >= 1 ? 'text-emerald-800' : 'text-slate-400' }}">
                            {{ $hasilLacak->created_at->format('d/m/Y H:i') }} WIB
                        </p>
                    </div>

                    <!-- Step 2: Verifikasi RT -->
                    <div class="p-4 rounded-2xl border-2 {{ $hasilLacak->status_step >= 2 ? 'bg-emerald-50 border-emerald-400 text-emerald-950' : ($hasilLacak->status_step == 1 ? 'bg-amber-50 border-amber-300 text-amber-950 animate-pulse' : 'bg-white border-slate-200 text-slate-400') }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-full {{ $hasilLacak->status_step >= 2 ? 'bg-emerald-600 text-white' : ($hasilLacak->status_step == 1 ? 'bg-amber-500 text-white' : 'bg-slate-200 text-slate-600') }} flex items-center justify-center font-bold text-sm">
                                2
                            </span>
                            @if($hasilLacak->status_step >= 2)
                                <span class="text-emerald-600 text-lg font-bold">✓</span>
                            @endif
                        </div>
                        <h4 class="font-black text-base">2. Verifikasi RT</h4>
                        <p class="text-xs mt-1">
                            @if($hasilLacak->verified_rt_at)
                                {{ $hasilLacak->verified_rt_at->format('d/m/Y H:i') }} WIB
                            @else
                                Menunggu Ketua RT {{ $hasilLacak->rt }}
                            @endif
                        </p>
                    </div>

                    <!-- Step 3: Persetujuan Kades -->
                    <div class="p-4 rounded-2xl border-2 {{ $hasilLacak->status_step >= 3 ? 'bg-emerald-50 border-emerald-400 text-emerald-950' : ($hasilLacak->status_step == 2 ? 'bg-amber-50 border-amber-300 text-amber-950 animate-pulse' : 'bg-white border-slate-200 text-slate-400') }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-full {{ $hasilLacak->status_step >= 3 ? 'bg-emerald-600 text-white' : ($hasilLacak->status_step == 2 ? 'bg-amber-500 text-white' : 'bg-slate-200 text-slate-600') }} flex items-center justify-center font-bold text-sm">
                                3
                            </span>
                            @if($hasilLacak->status_step >= 3)
                                <span class="text-emerald-600 text-lg font-bold">✓</span>
                            @endif
                        </div>
                        <h4 class="font-black text-base">3. Persetujuan Kades</h4>
                        <p class="text-xs mt-1">
                            @if($hasilLacak->approved_kades_at)
                                {{ $hasilLacak->approved_kades_at->format('d/m/Y H:i') }} WIB
                            @else
                                Menunggu Kepala Desa
                            @endif
                        </p>
                    </div>

                    <!-- Step 4: Surat Siap -->
                    <div class="p-4 rounded-2xl border-2 {{ $hasilLacak->status_step >= 4 ? 'bg-teal-50 border-teal-500 text-teal-950 shadow-md' : 'bg-white border-slate-200 text-slate-400' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-full {{ $hasilLacak->status_step >= 4 ? 'bg-teal-700 text-white' : 'bg-slate-200 text-slate-600' }} flex items-center justify-center font-bold text-sm">
                                4
                            </span>
                            @if($hasilLacak->status_step >= 4)
                                <span class="text-teal-700 text-lg font-bold">✓</span>
                            @endif
                        </div>
                        <h4 class="font-black text-base">4. Surat Terbit</h4>
                        <p class="text-xs mt-1">
                            @if($hasilLacak->no_surat_keterangan)
                                Siap Diunduh / Dicetak
                            @else
                                Menunggu Penomoran
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Detail & Aksi Unduh Surat -->
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Jika Selesai: Tampilkan Box Nomor Surat & Tombol Cetak PDF -->
                @if($hasilLacak->status === 'selesai')
                    <div class="p-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-3xl shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <span class="text-xs uppercase font-bold text-emerald-100 tracking-wider">🎉 Surat Resmi Telah Terbit:</span>
                            <h3 class="text-xl sm:text-2xl font-black font-mono mt-1">Nomor: {{ $hasilLacak->no_surat_keterangan }}</h3>
                            <p class="text-sm text-emerald-100 mt-1">
                                Tertanggal: {{ $hasilLacak->tgl_surat_keterangan?->translatedFormat('d F Y') ?? date('d F Y') }} &bull; Ditandatangani Kepala Desa Kebonpedes.
                            </p>
                        </div>

                        <a href="{{ route('ktp-hilang.cetak', $hasilLacak->id) }}" target="_blank" class="btn-touch px-6 py-4 bg-white hover:bg-slate-100 text-emerald-950 font-black text-base rounded-2xl shadow-xl transition transform hover:scale-105 flex items-center justify-center gap-2 shrink-0">
                            <span>🖨️ Cetak / Unduh Surat Resmi</span>
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-slate-700 bg-slate-50 p-6 rounded-2xl">
                    <div><strong>Tempat Hilang:</strong> {{ $hasilLacak->lokasi_kehilangan }}</div>
                    <div><strong>Tanggal Hilang:</strong> {{ $hasilLacak->tanggal_kehilangan->translatedFormat('d F Y') }}</div>
                    <div><strong>Domisili:</strong> RT {{ $hasilLacak->rt }} / RW {{ $hasilLacak->rw }}, {{ $hasilLacak->alamat }}</div>
                    <div><strong>Kontak:</strong> {{ $hasilLacak->no_hp }}</div>
                    <div class="sm:col-span-2 pt-2 border-t border-slate-200">
                        <strong>Kronologi:</strong> "{{ $hasilLacak->kronologi }}"
                    </div>
                    @if($hasilLacak->catatan_rt)
                        <div class="sm:col-span-2 text-blue-900 bg-blue-50 p-3 rounded-xl">
                            <strong>Catatan Verifikasi RT:</strong> {{ $hasilLacak->catatan_rt }}
                        </div>
                    @endif
                    @if($hasilLacak->catatan_kades)
                        <div class="sm:col-span-2 text-emerald-900 bg-emerald-50 p-3 rounded-xl">
                            <strong>Catatan Kepala Desa:</strong> {{ $hasilLacak->catatan_kades }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @elseif($kodeInput)
        <div class="bg-white p-8 rounded-3xl border-2 border-rose-200 text-center shadow-md">
            <span class="text-5xl block mb-2">🛑</span>
            <h3 class="text-2xl font-black text-slate-900 mb-2">Kode Lacak Tidak Ditemukan</h3>
            <p class="text-base text-slate-600 mb-4">
                Kode <strong>"{{ $kodeInput }}"</strong> tidak terdaftar dalam database permohonan surat {{ config('desa.nama_desa') }}.
            </p>
            <p class="text-sm text-slate-500">
                Pastikan Anda mengetik kode dengan benar lengkap dengan tanda strip (Contoh: <code>KTP-202610-C99Z</code>).
            </p>
        </div>
    @endif
</div>
@endsection
