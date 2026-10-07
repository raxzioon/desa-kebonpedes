@extends('layouts.app')

@section('title', 'Layanan Surat Keterangan KTP Hilang - ' . config('desa.nama_desa'))
@section('page_title', 'Layanan KTP Hilang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Header Hero Pelayanan -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 text-white rounded-3xl p-8 md:p-12 shadow-xl mb-12 relative overflow-hidden">
        <div class="decorative-bg absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-4 py-1.5 bg-emerald-500/30 border border-emerald-300/30 text-emerald-200 text-xs font-bold rounded-full uppercase tracking-wider inline-block mb-3">
                🆔 Layanan Cepat Administrasi Hukum (SDG 16)
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight leading-tight mb-4">
                Layanan Surat Keterangan Kehilangan KTP
            </h1>
            <p class="text-base sm:text-lg text-emerald-100 leading-relaxed mb-8">
                Bagi warga {{ config('desa.nama_desa') }} yang kehilangan KTP-el, ajukan surat keterangan resmi secara daring tanpa perlu antre di kantor desa. Lacak proses verifikasi dan unduh surat secara mandiri.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('ktp-hilang.create') }}" class="btn-touch px-8 py-4 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-lg rounded-2xl shadow-xl hover:shadow-2xl transition transform hover:-translate-y-0.5 flex items-center gap-3">
                    <span class="text-2xl">📝</span>
                    <span>Ajukan Permohonan Surat Sekarang</span>
                </a>
                <a href="{{ route('ktp-hilang.lacak') }}" class="btn-touch px-6 py-4 bg-white/10 hover:bg-white/20 text-white font-extrabold text-base rounded-2xl border-2 border-white/30 backdrop-blur-sm transition flex items-center gap-2">
                    <span class="text-xl">🔍</span>
                    <span>Lacak Status Pengajuan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 4 TAHAP ALUR PELAYANAN RESMI (VISUAL STEP-BY-STEP) -->
    <!-- ========================================================= -->
    <div class="mb-16">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="px-3.5 py-1 bg-emerald-100 text-emerald-900 font-bold text-xs rounded-full uppercase tracking-wider inline-block mb-2">
                Transparan & Mudah Dipahami
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                4 Langkah Mudah Pengurusan Surat KTP
            </h2>
            <p class="text-base text-slate-600 mt-2">
                Proses pengurusan dirancang sederhana, akurat, dan dapat dipantau setiap saat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
            <!-- Langkah 1 -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-md relative flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-amber-100 text-amber-900 rounded-2xl flex items-center justify-center text-2xl font-black mb-4 shadow-sm">
                        1
                    </div>
                    <h3 class="font-black text-xl text-slate-900 mb-2">Pengajuan Online</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">
                        Warga mengisi formulir identitas, kronologi kehilangan, dan mendapatkan <strong>Kode Lacak Unik</strong>.
                    </p>
                </div>
                <div class="text-xs font-bold text-amber-700 bg-amber-50 p-2.5 rounded-xl">
                    ⏱️ Waktu: 2 Menit (Mandiri)
                </div>
            </div>

            <!-- Langkah 2 -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-md relative flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-blue-100 text-blue-900 rounded-2xl flex items-center justify-center text-2xl font-black mb-4 shadow-sm">
                        2
                    </div>
                    <h3 class="font-black text-xl text-slate-900 mb-2">Verifikasi RT/RW</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">
                        Ketua RT memeriksa keabsahan data kependudukan dan memberikan catatan pengantar ke sistem.
                    </p>
                </div>
                <div class="text-xs font-bold text-blue-700 bg-blue-50 p-2.5 rounded-xl">
                    🏡 Oleh: Ketua RT Setempat
                </div>
            </div>

            <!-- Langkah 3 -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-md relative flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-900 rounded-2xl flex items-center justify-center text-2xl font-black mb-4 shadow-sm">
                        3
                    </div>
                    <h3 class="font-black text-xl text-slate-900 mb-2">Persetujuan Kades</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">
                        Kepala Desa menyetujui permohonan dan menerbitkan Nomor Surat Resmi Pemerintah Desa.
                    </p>
                </div>
                <div class="text-xs font-bold text-emerald-700 bg-emerald-50 p-2.5 rounded-xl">
                    🏛️ Oleh: Kepala Desa
                </div>
            </div>

            <!-- Langkah 4 -->
            <div class="bg-white p-6 rounded-3xl border-2 border-slate-200 shadow-md relative flex flex-col justify-between">
                <div>
                    <div class="w-14 h-14 bg-teal-100 text-teal-900 rounded-2xl flex items-center justify-center text-2xl font-black mb-4 shadow-sm">
                        4
                    </div>
                    <h3 class="font-black text-xl text-slate-900 mb-2">Surat Siap Digunakan</h3>
                    <p class="text-sm text-slate-600 leading-relaxed mb-4">
                        Surat Keterangan Kehilangan KTP resmi dapat langsung diunduh / dicetak oleh warga untuk Disdukcapil / Bank.
                    </p>
                </div>
                <div class="text-xs font-bold text-teal-700 bg-teal-50 p-2.5 rounded-xl">
                    📄 Surat Siap Diunduh PDF
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- WIDGET LACAK STATUS SURAT LANGSUNG -->
    <!-- ========================================================= -->
    <div class="bg-gradient-to-br from-emerald-50 to-teal-100 p-8 md:p-10 rounded-3xl border-2 border-emerald-300 shadow-lg text-center max-w-3xl mx-auto">
        <span class="text-4xl block mb-2">🔍</span>
        <h3 class="text-2xl md:text-3xl font-black text-emerald-950 mb-2">
            Sudah Memiliki Kode Lacak Pengajuan?
        </h3>
        <p class="text-base text-emerald-900 mb-6">
            Masukkan kode pelacakan yang Anda dapatkan saat mengajukan surat (Contoh: <code>KTP-202610-C99Z</code>).
        </p>

        <form action="{{ route('ktp-hilang.lacak') }}" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
            <input type="text" name="kode_lacak" required placeholder="KTP-202610-XXXX" class="w-full px-5 py-4 text-lg font-mono font-bold uppercase rounded-2xl border-2 border-emerald-400 focus:border-emerald-700 focus:ring-4 focus:ring-emerald-200 bg-white">
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-lg transition shrink-0">
                Lacak Status
            </button>
        </form>
    </div>
</div>
@endsection
