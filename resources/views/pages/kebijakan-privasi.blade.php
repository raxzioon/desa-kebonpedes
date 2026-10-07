@extends('layouts.app')

@section('title', 'Kebijakan Privasi & Perlindungan Data - ' . config('desa.nama_desa'))
@section('page_title', 'Kebijakan Privasi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border-2 border-slate-200">
        <div class="flex items-center gap-3 mb-6">
            <span class="text-4xl">🔒</span>
            <div>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-800 text-xs font-bold rounded-full uppercase tracking-wider">
                    Etika Profesi & Kepatuhan Regulasi
                </span>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mt-1">
                    Kebijakan Privasi & Perlindungan Data Pribadi
                </h1>
            </div>
        </div>

        <div class="prose prose-slate max-w-none text-base md:text-lg leading-relaxed space-y-6 text-slate-700">
            <div class="p-5 bg-emerald-50 rounded-2xl border-2 border-emerald-200 text-emerald-950 font-medium">
                Pemerintah {{ config('desa.nama_desa') }} berkomitmen penuh untuk melindungi privasi dan keamanan data kependudukan seluruh warga desa sesuai dengan amanat <strong>Undang-Undang No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong> dan kode etik profesi teknologi informasi.
            </div>

            <h2 class="text-2xl font-black text-slate-900 pt-4 border-t border-slate-200">
                1. Data Apa Saja yang Kami Kumpulkan?
            </h2>
            <p>
                Sistem Informasi Desa hanya mengumpulkan data yang mutlak diperlukan untuk kepentingan pelayanan publik administrasi desa:
            </p>
            <ul class="list-disc list-inside space-y-2">
                <li><strong>Identitas Dasar:</strong> Nama lengkap, NIK, No. Kartu Keluarga, tempat dan tanggal lahir, jenis kelamin.</li>
                <li><strong>Data Administrasi & Wilayah:</strong> Alamat domisili, RT, RW, agama, pendidikan, dan pekerjaan.</li>
                <li><strong>Data Kesehatan Balita:</strong> Berat badan, tinggi badan, lingkar kepala, dan status gizi balita pada saat pemeriksaan Posyandu.</li>
                <li><strong>Data Layanan Surat:</strong> Kronologi kehilangan KTP, nomor kontak WhatsApp, dan berkas persyaratan resmi.</li>
            </ul>

            <h2 class="text-2xl font-black text-slate-900 pt-4 border-t border-slate-200">
                2. Untuk Apa Data Tersebut Digunakan?
            </h2>
            <ul class="list-disc list-inside space-y-2">
                <li>Mempermudah penerbitan surat pengantar dan surat keterangan kehilangan KTP secara cepat dan akurat.</li>
                <li>Pemantauan dini pencegahan stunting pada balita oleh kader kesehatan desa.</li>
                <li>Perencanaan bantuan sosial dan gotong royong agar tepat sasaran kepada warga yang membutuhkan.</li>
                <li>Promosi produk UMKM warga desa untuk meningkatkan kesejahteraan ekonomi lokal.</li>
            </ul>

            <h2 class="text-2xl font-black text-slate-900 pt-4 border-t border-slate-200">
                3. Siapa yang Berhak Mengakses Data Anda? (RBAC)
            </h2>
            <p>
                Sistem menerapkan kontrol hak akses berlapis (<em>Role-Based Access Control</em>) di sisi server:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <h4 class="font-bold text-slate-900">Masyarakat Umum</h4>
                    <p class="text-xs text-slate-600 mt-1">Hanya melihat data agregat non-rahasia, etalase UMKM, pengumuman gotong royong, dan status lacak surat miliknya sendiri.</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-2xl border border-blue-200">
                    <h4 class="font-bold text-blue-900">Ketua RT / RW</h4>
                    <p class="text-xs text-blue-800 mt-1">Hanya dapat melihat dan mengelola data warga di wilayah RT/RW miliknya sendiri.</p>
                </div>
                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200">
                    <h4 class="font-bold text-amber-900">Kader Posyandu</h4>
                    <p class="text-xs text-amber-800 mt-1">Hanya memiliki akses terhadap data kesehatan dan tumbuh kembang balita.</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200">
                    <h4 class="font-bold text-emerald-900">Kepala Desa</h4>
                    <p class="text-xs text-emerald-800 mt-1">Memiliki hak persetujuan resmi, pengawasan audit trail, dan tata kelola akun aparatur.</p>
                </div>
            </div>

            <h2 class="text-2xl font-black text-slate-900 pt-4 border-t border-slate-200">
                4. Penyamaran Data Sensitif (Masking NIK)
            </h2>
            <p>
                Seluruh tampilan publik dan daftar ringkas secara otomatis menyamarkan 6 digit tengah NIK (contoh: <code>320214******0001</code>). Data nomor identitas lengkap hanya dapat dibuka oleh peran yang berwenang untuk validasi dokumen dinas.
            </p>

            <h2 class="text-2xl font-black text-slate-900 pt-4 border-t border-slate-200">
                5. Persetujuan Eksplisit Warga (Explicit Opt-In)
            </h2>
            <p>
                Setiap pencatatan data warga baru atau pengajuan surat wajib menyertakan persetujuan warga melalui kotak centang persetujuan yang tercatat secara digital beserta stempel waktu (<em>timestamp</em>) di dalam basis data sistem.
            </p>

            <div class="mt-8 pt-6 border-t-2 border-slate-200 text-center">
                <a href="{{ route('home') }}" class="btn-touch px-8 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-base rounded-2xl shadow transition">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
