<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan KTP Hilang - {{ $ktp->nama_pemohon }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12pt; background: white; color: black; }
            .letter-paper { box-shadow: none !important; border: none !important; padding: 0 !important; width: 100% !important; margin: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-8 text-slate-900 font-serif">

    <!-- Tombol Aksi Layar (Tidak Tercetak) -->
    <div class="no-print max-w-3xl mx-auto mb-6 px-4 flex items-center justify-between font-sans">
        <a href="{{ route('ktp-hilang.lacak', ['kode_lacak' => $ktp->kode_lacak]) }}" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-black transition">
            &larr; Kembali ke Status Pelacakan
        </a>

        <div class="flex gap-3">
            <button onclick="window.print()" class="px-6 py-2.5 bg-emerald-700 text-white rounded-xl font-black text-sm shadow hover:bg-emerald-800 transition flex items-center gap-2">
                <span>🖨️ Cetak Dokumen / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- LEMBAR DOKUMEN RESMI (KOP SURAT PEMERINTAH DESA) -->
    <div class="letter-paper max-w-3xl mx-auto bg-white p-12 sm:p-16 rounded-2xl shadow-2xl border border-slate-300">
        <!-- KOP SURAT RESMI -->
        <div class="border-b-4 border-double border-slate-900 pb-4 mb-6 text-center relative">
            <div class="text-sm font-bold uppercase tracking-widest text-slate-700 leading-tight">
                PEMERINTAH KABUPATEN {{ strtoupper(config('desa.kabupaten')) }}
            </div>
            <div class="text-base font-bold uppercase tracking-widest text-slate-800 leading-tight">
                KECAMATAN {{ strtoupper(config('desa.kecamatan')) }}
            </div>
            <div class="text-2xl sm:text-3xl font-black uppercase tracking-wider text-slate-950 mt-1">
                KANTOR KEPALA DESA {{ strtoupper(config('desa.nama_desa')) }}
            </div>
            <div class="text-xs text-slate-600 font-sans mt-1">
                {{ config('desa.alamat_kantor') }} &bull; Kode Pos: {{ config('desa.kode_pos') }}
            </div>
            <div class="text-xs text-slate-600 font-sans">
                Surel: {{ config('desa.email') }} &bull; Telp/WA: {{ config('desa.telepon') }}
            </div>
        </div>

        <!-- JUDUL SURAT & NOMOR -->
        <div class="text-center my-6">
            <h1 class="text-lg sm:text-xl font-black uppercase underline tracking-wide">
                SURAT KETERANGAN KEHILANGAN KTP
            </h1>
            <p class="font-mono text-sm font-bold text-slate-800 mt-1">
                Nomor: {{ $ktp->no_surat_keterangan ?? '474.2/105/Pem-Des/X/2026' }}
            </p>
        </div>

        <!-- ISI SURAT -->
        <div class="text-justify text-sm sm:text-base leading-relaxed space-y-4 my-6">
            <p>
                Yang bertanda tangan di bawah ini, Kepala Desa {{ config('desa.nama_desa') }}, Kecamatan {{ config('desa.kecamatan') }}, Kabupaten {{ config('desa.kabupaten') }}, Provinsi {{ config('desa.provinsi') }}, dengan ini menerangkan dengan sebenarnya bahwa:
            </p>

            <table class="w-full my-4 text-sm sm:text-base font-sans">
                <tbody>
                    <tr class="py-1">
                        <td class="w-48 font-semibold py-1">Nama Lengkap</td>
                        <td class="w-4">:</td>
                        <td class="font-bold uppercase text-slate-950 py-1">{{ $ktp->nama_pemohon }}</td>
                    </tr>
                    <tr class="py-1">
                        <td class="font-semibold py-1">NIK</td>
                        <td>:</td>
                        <td class="font-mono font-bold py-1">{{ $ktp->nik_pemohon }}</td>
                    </tr>
                    <tr class="py-1">
                        <td class="font-semibold py-1">Tempat / Tgl Lahir</td>
                        <td>:</td>
                        <td class="py-1">{{ $ktp->tempat_lahir }}, {{ $ktp->tanggal_lahir->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr class="py-1">
                        <td class="font-semibold py-1">Jenis Kelamin</td>
                        <td>:</td>
                        <td class="py-1">{{ $ktp->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr class="py-1">
                        <td class="font-semibold py-1">Agama</td>
                        <td>:</td>
                        <td class="py-1">{{ $ktp->agama }}</td>
                    </tr>
                    <tr class="py-1">
                        <td class="font-semibold py-1">Pekerjaan</td>
                        <td>:</td>
                        <td class="py-1">{{ $ktp->pekerjaan }}</td>
                    </tr>
                    <tr class="py-1">
                        <td class="font-semibold py-1">Alamat Domisili</td>
                        <td>:</td>
                        <td class="py-1">{{ $ktp->alamat }}, RT {{ $ktp->rt }} / RW {{ $ktp->rw }}, {{ config('desa.nama_desa') }}</td>
                    </tr>
                </tbody>
            </table>

            <p>
                Berdasarkan laporan yang kami terima dan verifikasi Ketua RT {{ $ktp->rt }}/RW {{ $ktp->rw }}, nama tersebut di atas benar-benar penduduk Desa {{ config('desa.nama_desa') }} yang telah <strong>KEHILANGAN KARTU TANDA PENDUDUK ELEKTRONIK (KTP-el)</strong> pada:
            </p>

            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 font-sans text-sm space-y-1 my-3">
                <div><strong>Hari / Tanggal Kejadian:</strong> {{ $ktp->tanggal_kehilangan->translatedFormat('l, d F Y') }}</div>
                <div><strong>Lokasi Kehilangan:</strong> {{ $ktp->lokasi_kehilangan }}</div>
                <div><strong>Kronologi:</strong> "{{ $ktp->kronologi }}"</div>
            </div>

            <p>
                Surat Keterangan ini diberikan kepada yang bersangkutan sebagai <strong>Tanda Bukti Sementara Pengganti KTP</strong> guna keperluan pengurusan pencetakan ulang KTP-el di Kantor Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) Kabupaten {{ config('desa.kabupaten') }} atau instansi pelayanan perbankan/umum lainnya.
            </p>

            <p>
                Demikian surat keterangan ini kami buat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.
            </p>
        </div>

        <!-- TANDA TANGAN KEPALA DESA & STEMPEL -->
        <div class="mt-12 flex justify-between items-end font-sans">
            <!-- QR Code Validasi Keaslian -->
            <div class="text-center p-3 border border-slate-200 rounded-xl bg-slate-50 text-xs">
                <div class="w-20 h-20 bg-slate-900 text-white flex items-center justify-center mx-auto mb-1 text-2xl font-mono">
                    QR-DESA
                </div>
                <div class="font-mono font-bold text-slate-700">{{ $ktp->kode_lacak }}</div>
                <div class="text-[10px] text-slate-500">Verifikasi Digital Resmi</div>
            </div>

            <!-- Tanda Tangan Kades -->
            <div class="text-center w-64">
                <p class="text-sm">{{ config('desa.kecamatan') }}, {{ $ktp->tgl_surat_keterangan?->translatedFormat('d F Y') ?? date('d F Y') }}</p>
                <p class="text-sm font-bold uppercase mt-1">Kepala Desa {{ config('desa.nama_desa') }}</p>

                <div class="h-20 flex items-center justify-center my-1 relative">
                    <span class="text-xs text-slate-400 font-mono italic">[ Ditandatangani Secara Elektronik ]</span>
                    <div class="absolute w-24 h-24 border-2 border-emerald-600 rounded-full opacity-30 pointer-events-none flex items-center justify-center font-bold text-emerald-800 text-[10px] rotate-12">
                        CAP RESMI DESA
                    </div>
                </div>

                <p class="font-black text-slate-950 underline text-base">{{ config('desa.nama_kades') }}</p>
                <p class="text-xs text-slate-600 font-mono">NIP: {{ config('desa.nip_kades') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
