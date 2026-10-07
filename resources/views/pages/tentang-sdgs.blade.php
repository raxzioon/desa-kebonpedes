@extends('layouts.app')

@section('title', 'Keterkaitan SDGs (Tujuan Pembangunan Berkelanjutan) - ' . config('desa.nama_desa'))
@section('page_title', 'Keterkaitan SDGs')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border-2 border-slate-200">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="px-4 py-1.5 bg-blue-100 text-blue-900 font-bold text-xs rounded-full border border-blue-300 inline-block mb-3">
                🌍 Agenda Pembangunan Berkelanjutan 2030
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight mb-4">
                Penyelarasan Fitur Sistem dengan SDGs
            </h1>
            <p class="text-base md:text-lg text-slate-600 leading-relaxed">
                Sistem Informasi Desa Kebonpedes dirancang tidak hanya untuk digitalisasi administrasi, melainkan turut berkontribusi nyata terhadap indikator capaian Tujuan Pembangunan Berkelanjutan (<em>Sustainable Development Goals</em> / SDGs Desa).
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- SDG 2 & 3: Stunting & Kesehatan -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-amber-50 to-orange-50 border-2 border-amber-300 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 bg-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md">
                        2 & 3
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-slate-900 leading-tight">SDG 2 & 3: Tanpa Kelaparan & Kesehatan Sejahtera</h3>
                        <p class="text-xs font-bold text-amber-800">Zero Hunger & Good Health</p>
                    </div>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed mb-3">
                    <strong>Penerapan dalam Sistem:</strong> Modul <em>Pemantauan Balita & Gizi Stunting</em> oleh Kader Posyandu. Sistem menghitung status gizi balita secara otomatis, memetakan risiko gizi kurang/buruk, dan mengatur jadwal distribusi Pemberian Makanan Tambahan (PMT) serta vitamin secara tepat sasaran.
                </p>
                <span class="inline-block px-3 py-1 bg-amber-200 text-amber-900 text-xs font-bold rounded-lg">
                    Fitur: Modul Data Stunting & Notifikasi Gizi
                </span>
            </div>

            <!-- SDG 8: UMKM & Pertumbuhan Ekonomi -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-teal-50 to-emerald-50 border-2 border-teal-300 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 bg-teal-600 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md">
                        8
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-slate-900 leading-tight">SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi</h3>
                        <p class="text-xs font-bold text-teal-800">Decent Work & Economic Growth</p>
                    </div>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed mb-3">
                    <strong>Penerapan dalam Sistem:</strong> Fitur <em>Etalase Digital UMKM Desa</em> yang menghubungkan langsung hasil olahan warga (keripik, gula aren, anyaman bambu, dsb.) dengan pasar desa dan pembeli luas melalui integrasi pemesanan WhatsApp tanpa perantara.
                </p>
                <span class="inline-block px-3 py-1 bg-teal-200 text-teal-900 text-xs font-bold rounded-lg">
                    Fitur: Pasar UMKM & Promosi Produk Desa
                </span>
            </div>

            <!-- SDG 16: Identitas Hukum & Tata Kelola Transparan -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-300 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 bg-blue-700 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md">
                        16
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-slate-900 leading-tight">SDG 16: Perdamaian, Keadilan & Kelembagaan Tangguh</h3>
                        <p class="text-xs font-bold text-blue-800">Peace, Justice & Strong Institutions</p>
                    </div>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed mb-3">
                    <strong>Penerapan dalam Sistem:</strong> Jaminan identitas hukum melalui <em>Layanan Surat KTP Hilang</em> berbasis kode lacak publik, serta transparansi tata kelola aparatur desa melalui <em>Sistem Audit Log Otomatis</em> yang merekam setiap perubahan data secara akuntabel.
                </p>
                <span class="inline-block px-3 py-1 bg-blue-200 text-blue-900 text-xs font-bold rounded-lg">
                    Fitur: Layanan KTP Hilang & Audit Log Kades
                </span>
            </div>

            <!-- SDG 11 & 17: Gotong Royong & Kemitraan Warga -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-50 to-green-50 border-2 border-emerald-300 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-14 h-14 bg-emerald-700 text-white rounded-2xl flex items-center justify-center text-2xl font-black shadow-md">
                        11 & 17
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-slate-900 leading-tight">SDG 11 & 17: Pemukiman Berkelanjutan & Kemitraan</h3>
                        <p class="text-xs font-bold text-emerald-800">Sustainable Communities & Partnerships</p>
                    </div>
                </div>
                <p class="text-sm text-slate-700 leading-relaxed mb-3">
                    <strong>Penerapan dalam Sistem:</strong> Papan kegiatan <em>Gotong Royong & Relawan Desa</em> yang memfasilitasi kerja bakti lingkungan, santunan sosial lansia, dan partisipasi aktif warga dalam menjaga kelestarian desa secara kolaboratif.
                </p>
                <span class="inline-block px-3 py-1 bg-emerald-200 text-emerald-900 text-xs font-bold rounded-lg">
                    Fitur: Papan Gotong Royong & Relawan
                </span>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t-2 border-slate-200 text-center">
            <a href="{{ route('home') }}" class="btn-touch px-8 py-3.5 bg-slate-900 hover:bg-black text-white font-bold text-base rounded-2xl shadow transition">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
