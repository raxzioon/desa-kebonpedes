<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Identitas Desa (Simulasi / Contoh)
    |--------------------------------------------------------------------------
    |
    | Digunakan di semua tampilan: Header, Beranda, Footer, Judul Tab, dan
    | Dokumen Surat. Terpusat di satu file agar mudah disesuaikan.
    |
    */

    'nama_desa' => env('DESA_NAMA', 'Desa Kebonpedes'),
    'kode_desa' => env('DESA_KODE', '32.02.14.2001'),
    'kecamatan' => env('DESA_KECAMATAN', 'Kecamatan (contoh)'),
    'kabupaten' => env('DESA_KABUPATEN', 'Kabupaten (contoh)'),
    'provinsi' => env('DESA_PROVINSI', 'Jawa Barat'),
    'kode_pos' => env('DESA_KODE_POS', '43194'),
    
    // Kontak & Pelayanan Kantor Desa
    'telepon' => env('DESA_TELEPON', '0812-3456-7890'),
    'whatsapp_pusat' => env('DESA_WA', '6281234567890'),
    'email' => env('DESA_EMAIL', 'pelayanan@kebonpedes.desa.id'),
    'alamat_kantor' => env('DESA_ALAMAT', 'Jl. Kebonpedes Raya No. 45, RT 02/RW 01'),
    'jam_pelayanan' => 'Senin - Jumat: 08.00 - 15.30 WIB',

    // Aparatur Desa (Placeholder Contoh)
    'nama_kades' => env('DESA_KADES', 'Kepala Desa (contoh)'),
    'nip_kades' => env('DESA_KADES_NIP', '19750412 200212 1 003'),
    'nama_sekdes' => env('DESA_SEKDES', 'Sekretaris Desa (contoh)'),

    // Keterangan Sistem
    'deskripsi' => 'Sistem informasi kependudukan, pemantauan kesehatan balita, dan etalase UMKM Desa Kebonpedes.',

    // Konfigurasi Wilayah RT / RW
    'daftar_rw' => ['01', '02', '03'],
    'daftar_rt' => [
        '01' => ['01', '02', '03'],
        '02' => ['01', '02'],
        '03' => ['01', '02'],
    ],

    // Keterangan Akademik
    'demo_mode' => true,
    'app_academic_note' => 'Prototype tugas kuliah S1 Sistem Informasi Telkom University (APSI, Perancangan Interaksi, Etika Profesi). Semua data adalah data contoh fiktif.',
];
