<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\Stunting;
use App\Models\PindahWarga;
use App\Models\KematianWarga;
use App\Models\KtpHilang;
use App\Models\Umkm;
use App\Models\Kegiatan;
use App\Models\RelawanKegiatan;
use App\Models\AuditLog;
use App\Models\Panduan;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. PENGGUNA RESMI & AKUN DEMO PERAN
        // ==========================================
        $kades = User::updateOrCreate(
            ['email' => 'kades@kebonpedes.desa.id'],
            [
                'name' => config('desa.nama_kades', 'Kepala Desa (contoh)'),
                'password' => Hash::make('password'),
                'role' => 'kades',
                'phone' => '0812-1122-3344',
                'jabatan' => 'Kepala Desa Kebonpedes',
                'is_active' => true,
            ]
        );

        $rt01 = User::updateOrCreate(
            ['email' => 'rt01@kebonpedes.desa.id'],
            [
                'name' => 'Bpk. Cecep Supriatna',
                'password' => Hash::make('password'),
                'role' => 'rt_rw',
                'rt' => '01',
                'rw' => '01',
                'phone' => '0813-2233-4455',
                'jabatan' => 'Ketua RT 01 / RW 01',
                'is_active' => true,
            ]
        );

        $rt02 = User::updateOrCreate(
            ['email' => 'rt02@kebonpedes.desa.id'],
            [
                'name' => 'Bpk. Ujang Suherman',
                'password' => Hash::make('password'),
                'role' => 'rt_rw',
                'rt' => '02',
                'rw' => '01',
                'phone' => '0813-5566-7788',
                'jabatan' => 'Ketua RT 02 / RW 01',
                'is_active' => true,
            ]
        );

        $kader = User::updateOrCreate(
            ['email' => 'kader@kebonpedes.desa.id'],
            [
                'name' => 'Ibu Hj. Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'kader',
                'rt' => '01',
                'rw' => '01',
                'phone' => '0857-9988-1122',
                'jabatan' => 'Ketua Kader Posyandu Melati',
                'is_active' => true,
            ]
        );

        // ==========================================
        // 2. DATA PENDUDUK (Minimal 40 Data Fiktif)
        // ==========================================
        $pekerjaanList = ['Petani', 'Pedagang Pasar', 'Buruh Bangunan', 'Wiraswasta', 'Ibu Rumah Tangga', 'Guru Honorer', 'Karyawan Swasta', 'PNS', 'Pelajar / Mahasiswa', 'Peternak'];
        $pendidikanList = ['SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D3', 'S1'];
        $agamaList = ['Islam', 'Islam', 'Islam', 'Islam', 'Kristen'];
        $goldarList = ['A', 'B', 'AB', 'O'];

        $pendudukRaw = [
            // RT 01 / RW 01
            ['3202141501800001', '3202140101800001', 'Ahmad Sudrajat', 'L', 'Sukabumi', '1980-01-15', 'Menikah', 'Petani', 'SMA/Sederajat', '01', '01', 'Kp. Kebonpedes Girang No. 12'],
            ['3202145503830002', '3202140101800001', 'Kokom Komalasari', 'P', 'Sukabumi', '1983-03-25', 'Menikah', 'Ibu Rumah Tangga', 'SMP/Sederajat', '01', '01', 'Kp. Kebonpedes Girang No. 12'],
            ['3202141208050003', '3202140101800001', 'Rizky Sudrajat', 'L', 'Sukabumi', '2005-08-12', 'Belum Menikah', 'Pelajar / Mahasiswa', 'SMA/Sederajat', '01', '01', 'Kp. Kebonpedes Girang No. 12'],
            ['3202142205750004', '3202140101750002', 'Budi Santoso', 'L', 'Bandung', '1975-05-22', 'Menikah', 'Pedagang Pasar', 'SMA/Sederajat', '01', '01', 'Jl. Sukaraja No. 04'],
            ['3202146109780005', '3202140101750002', 'Eneng Rohaeti', 'P', 'Sukabumi', '1978-09-21', 'Menikah', 'Wiraswasta (Keripik Singkong)', 'SMP/Sederajat', '01', '01', 'Jl. Sukaraja No. 04'],
            ['3202140404030006', '3202140101750002', 'Fajar Ramadhan', 'L', 'Sukabumi', '2003-04-04', 'Belum Menikah', 'Wiraswasta', 'SMA/Sederajat', '01', '01', 'Jl. Sukaraja No. 04'],
            ['3202141010500007', '3202140101500003', 'Abah Mansyur', 'L', 'Sukabumi', '1950-10-10', 'Cerai Mati', 'Petani', 'SD/Sederajat', '01', '01', 'Gang Saluyu No. 01'],
            ['3202142512880008', '3202140101880004', 'Dadan Hamdani', 'L', 'Sukabumi', '1988-12-25', 'Menikah', 'Buruh Bangunan', 'SMP/Sederajat', '01', '01', 'Gang Melati No. 08'],
            ['3202146802900009', '3202140101880004', 'Mimin Mintarsih', 'P', 'Sukabumi', '1990-02-28', 'Menikah', 'Ibu Rumah Tangga', 'SMA/Sederajat', '01', '01', 'Gang Melati No. 08'],
            ['3202141907680010', '3202140101680005', 'Iskandar Zulkarnain', 'L', 'Cianjur', '1968-07-19', 'Menikah', 'PNS Guru', 'S1', '01', '01', 'Jl. Balai Desa No. 19'],
            ['3202145911720011', '3202140101680005', 'Ratna Juwita', 'P', 'Sukabumi', '1972-11-19', 'Menikah', 'Ibu Rumah Tangga', 'SMA/Sederajat', '01', '01', 'Jl. Balai Desa No. 19'],
            ['3202140506000012', '3202140101680005', 'Dimas Iskandar', 'L', 'Sukabumi', '2000-06-05', 'Belum Menikah', 'Karyawan Swasta', 'S1', '01', '01', 'Jl. Balai Desa No. 19'],
            ['3202141401920013', '3202140101920006', 'Hendra Gunawan', 'L', 'Sukabumi', '1992-01-14', 'Menikah', 'Peternak Bebek', 'SMA/Sederajat', '01', '01', 'Kp. Kebonpedes Girang No. 33'],
            ['3202144908940014', '3202140101920006', 'Dewi Sartika', 'P', 'Sukabumi', '1994-08-09', 'Menikah', 'Ibu Rumah Tangga', 'SMA/Sederajat', '01', '01', 'Kp. Kebonpedes Girang No. 33'],

            // RT 02 / RW 01
            ['3202141103770015', '3202140102770001', 'Yayan Hendriyana', 'L', 'Sukabumi', '1977-03-11', 'Menikah', 'Pedagang Sayur', 'SMP/Sederajat', '02', '01', 'Jl. Pesantren No. 05'],
            ['3202145207800016', '3202140102770001', 'Lilis Karlina', 'P', 'Sukabumi', '1980-07-12', 'Menikah', 'Ibu Rumah Tangga', 'SD/Sederajat', '02', '01', 'Jl. Pesantren No. 05'],
            ['3202140109010017', '3202140102770001', 'Aris Hendriyana', 'L', 'Sukabumi', '2001-09-01', 'Belum Menikah', 'Wiraswasta', 'SMA/Sederajat', '02', '01', 'Jl. Pesantren No. 05'],
            ['3202142010850018', '3202140102850002', 'Tatang Sutisna', 'L', 'Sukabumi', '1985-10-20', 'Menikah', 'Buruh Tani', 'SD/Sederajat', '02', '01', 'Gang Masjid Al-Barokah No. 02'],
            ['3202146312890019', '3202140102850002', 'Cucun Cundartini', 'P', 'Sukabumi', '1989-12-23', 'Menikah', 'Ibu Rumah Tangga', 'SMP/Sederajat', '02', '01', 'Gang Masjid Al-Barokah No. 02'],
            ['3202141505620020', '3202140102620003', 'H. Endang Sujana', 'L', 'Sukabumi', '1962-05-15', 'Menikah', 'Pensiunan PNS', 'S1', '02', '01', 'Jl. Raya Kebonpedes No. 88'],
            ['3202144809650021', '3202140102620003', 'Hj. Neneng Hasanah', 'P', 'Sukabumi', '1965-09-08', 'Menikah', 'Ibu Rumah Tangga', 'SMA/Sederajat', '02', '01', 'Jl. Raya Kebonpedes No. 88'],
            ['3202141708960022', '3202140102960004', 'Agus Setiawan', 'L', 'Sukabumi', '1996-08-17', 'Menikah', 'Mekanik Bengkel', 'SMK/Sederajat', '02', '01', 'Jl. Pesantren No. 14'],
            ['3202145104980023', '3202140102960004', 'Nisa Nurul Aini', 'P', 'Sukabumi', '1998-04-11', 'Menikah', 'Penjahit Pakaian', 'SMA/Sederajat', '02', '01', 'Jl. Pesantren No. 14'],
            ['3202140803480024', '3202140102480005', 'Mak Ijot', 'P', 'Sukabumi', '1948-03-08', 'Cerai Mati', 'Tidak Bekerja (Lansia)', 'Tidak/Belum Sekolah', '02', '01', 'Gang Sukamaju No. 07'],
            ['3202142906840025', '3202140102840006', 'Dedi Mulyadi', 'L', 'Sukabumi', '1984-06-29', 'Menikah', 'Sopir Angkot', 'SMP/Sederajat', '02', '01', 'Jl. Babakan No. 21'],
            ['3202146401870026', '3202140102840006', 'Imas Masitoh', 'P', 'Sukabumi', '1987-01-24', 'Menikah', 'Pedagang Gorengan', 'SD/Sederajat', '02', '01', 'Jl. Babakan No. 21'],

            // RT 03 / RW 01
            ['3202141302820027', '3202140103820001', 'Kosasih', 'L', 'Sukabumi', '1982-02-13', 'Menikah', 'Perajin Anyaman Bambu', 'SMP/Sederajat', '03', '01', 'Kp. Sawah Lega No. 09'],
            ['3202145508860028', '3202140103820001', 'Siti Aminah', 'P', 'Sukabumi', '1986-08-15', 'Menikah', 'Ibu Rumah Tangga', 'SD/Sederajat', '03', '01', 'Kp. Sawah Lega No. 09'],
            ['3202142805900029', '3202140103900002', 'Rahmat Fauzi', 'L', 'Sukabumi', '1990-05-28', 'Menikah', 'Guru Madrasah', 'S1', '03', '01', 'Gang Musholla No. 03'],
            ['3202147009930030', '3202140103900002', 'Fitri Handayani', 'P', 'Sukabumi', '1993-09-30', 'Menikah', 'Bidan Desa', 'D3', '03', '01', 'Gang Musholla No. 03'],
            ['3202140912700031', '3202140103700003', 'Samsudin', 'L', 'Sukabumi', '1970-12-09', 'Menikah', 'Petani Cabai', 'SD/Sederajat', '03', '01', 'Kp. Sawah Lega No. 18'],
            ['3202144703740032', '3202140103700003', 'Aan Rohanah', 'P', 'Sukabumi', '1974-03-07', 'Menikah', 'Ibu Rumah Tangga', 'SD/Sederajat', '03', '01', 'Kp. Sawah Lega No. 18'],
            ['3202141804020033', '3202140103700003', 'Wawan Samsudin', 'L', 'Sukabumi', '2002-04-18', 'Belum Menikah', 'Buruh Tani', 'SMP/Sederajat', '03', '01', 'Kp. Sawah Lega No. 18'],

            // RW 02
            ['3202141111790034', '3202140201790001', 'Jajang Nurjaman', 'L', 'Sukabumi', '1979-11-11', 'Menikah', 'Peternak Ayam', 'SMA/Sederajat', '01', '02', 'Kp. Pasir Salam No. 04'],
            ['3202145305820035', '3202140201790001', 'Yuyun Yuningsih', 'P', 'Sukabumi', '1982-05-13', 'Menikah', 'Ibu Rumah Tangga', 'SMP/Sederajat', '01', '02', 'Kp. Pasir Salam No. 04'],
            ['3202142407880036', '3202140201880002', 'Lukman Hakim', 'L', 'Sukabumi', '1988-07-24', 'Menikah', 'Karyawan Swasta', 'S1', '01', '02', 'Jl. Alternatif No. 12'],
            ['3202146610910037', '3202140201880002', 'Neneng Maryati', 'P', 'Sukabumi', '1991-10-26', 'Menikah', 'Ibu Rumah Tangga', 'SMA/Sederajat', '01', '02', 'Jl. Alternatif No. 12'],
            ['3202140303600038', '3202140202600003', 'Pak RT Mulyadi', 'L', 'Sukabumi', '1960-03-03', 'Menikah', 'Wiraswasta Toko Kelontong', 'SMA/Sederajat', '02', '02', 'Jl. Pasir Salam No. 25'],
            ['3202144507640039', '3202140202600003', 'Ibu Mimin', 'P', 'Sukabumi', '1964-07-05', 'Menikah', 'Pedagang', 'SMP/Sederajat', '02', '02', 'Jl. Pasir Salam No. 25'],
            ['3202141512950040', '3202140202950004', 'Rian Hidayat', 'L', 'Sukabumi', '1995-12-15', 'Belum Menikah', 'Programmer Lepas', 'S1', '02', '02', 'Jl. Pasir Salam No. 30'],
            ['3202142201970041', '3202140202970005', 'Galih Permana', 'L', 'Sukabumi', '1997-01-22', 'Menikah', 'Pengrajin Sepatu Kulit', 'SMA/Sederajat', '02', '02', 'Gang Saluyu II No. 11'],
            ['3202146503990042', '3202140202970005', 'Rina Agustina', 'P', 'Sukabumi', '1999-03-25', 'Menikah', 'Ibu Rumah Tangga', 'SMA/Sederajat', '02', '02', 'Gang Saluyu II No. 11'],
        ];

        $pendudukModels = [];
        foreach ($pendudukRaw as $p) {
            $created = Penduduk::create([
                'nik' => $p[0],
                'no_kk' => $p[1],
                'nama' => $p[2],
                'jenis_kelamin' => $p[3],
                'tempat_lahir' => $p[4],
                'tanggal_lahir' => Carbon::parse($p[5]),
                'agama' => 'Islam',
                'pendidikan' => $p[8],
                'pekerjaan' => $p[7],
                'status_pernikahan' => $p[6],
                'golongan_darah' => $goldarList[array_rand($goldarList)],
                'rt' => $p[9],
                'rw' => $p[10],
                'alamat' => $p[11],
                'status_dasar' => 'hidup',
                'opt_in_persetujuan' => true,
                'opt_in_at' => Carbon::now()->subMonths(rand(1, 12)),
                'created_by_user_id' => $rt01->id,
            ]);
            $pendudukModels[] = $created;
        }

        // ==========================================
        // 3. DATA KESEHATAN BALITA & STUNTING (15 Data Fiktif)
        // ==========================================
        $stuntingData = [
            ['Muhammad Alif Pratama', '3202140501240001', '2024-01-05', 'L', 'Kokom Komalasari', 'Ahmad Sudrajat', '01', '01', 9.2, 77.5, 45.0, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Melati 1', 'Pertumbuhan sangat baik, lingkar kepala normal', 'Pemberian Vitamin A dosis biru'],
            ['Aisyah Nur Salsabila', '3202144203240002', '2024-03-12', 'P', 'Mimin Mintarsih', 'Dadan Hamdani', '01', '01', 7.1, 71.0, 42.5, 'Gizi Kurang', 'Pendek (Stunted)', 'Posyandu Melati 1', 'Tinggi badan di bawah grafik standar WHO (-2SD)', 'Intervensi PMT Biskuit Balita & Telur Rebus harian'],
            ['Kenzo Daniswara', '3202141506230003', '2023-06-15', 'L', 'Dewi Sartika', 'Hendra Gunawan', '01', '01', 11.5, 87.0, 47.5, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Melati 1', 'Balita aktif dan sehat, imunisasi dasar lengkap', 'Edukasi gizi seimbang'],
            ['Bilqis Humaira', '3202145509230004', '2023-09-25', 'P', 'Cucun Cundartini', 'Tatang Sutisna', '02', '01', 8.0, 75.0, 43.0, 'Gizi Kurang', 'Sangat Pendek (Severely Stunted)', 'Posyandu Mawar 2', 'Tinggi badan -3SD dari kurva standar. Perlu rujukan Puskesmas', 'PMT Pemulihan, Pendampingan Khusus Bidan Desa & Taburia'],
            ['Raffasya Malik', '3202141011230005', '2023-11-10', 'L', 'Nisa Nurul Aini', 'Agus Setiawan', '02', '01', 9.8, 81.0, 46.0, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Mawar 2', 'Nafsu makan bagus, grafik pertumbuhan hijau', 'Pemberian tablet zat besi'],
            ['Zahra Putri Az-Zahra', '3202146202240006', '2024-02-22', 'P', 'Imas Masitoh', 'Dedi Mulyadi', '02', '01', 7.4, 72.5, 43.2, 'Gizi Kurang', 'Pendek (Stunted)', 'Posyandu Mawar 2', 'Perlu perhatian variasi makanan pendamping ASI', 'PMT Modisco lokal (kacang hijau & susu)'],
            ['Fathian Arkananta', '3202141804240007', '2024-04-18', 'L', 'Siti Aminah', 'Kosasih', '03', '01', 8.5, 76.0, 44.5, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Kenanga 3', 'Kenaikan berat badan konsisten setiap bulan', 'Imunisasi DPT lanjutan'],
            ['Khaira Wilda', '3202145805230008', '2023-05-28', 'P', 'Fitri Handayani', 'Rahmat Fauzi', '03', '01', 12.0, 89.5, 48.0, 'Gizi Baik (Normal)', 'Tinggi', 'Posyandu Kenanga 3', 'Tumbuh kembang optimal di atas rata-rata', 'Konseling gizi seimbang'],
            ['Arjuna Rayyan', '3202142007230009', '2023-07-20', 'L', 'Yuyun Yuningsih', 'Jajang Nurjaman', '01', '02', 10.1, 82.5, 46.2, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Anggrek 1', 'Sehat dan ceria', 'Pemberian vitamin A'],
            ['Nadhira Syakila', '3202146410230010', '2023-10-24', 'P', 'Neneng Maryati', 'Lukman Hakim', '01', '02', 8.2, 74.0, 43.5, 'Gizi Kurang', 'Pendek (Stunted)', 'Posyandu Anggrek 1', 'Kenaikan TB melambat dalam 2 bulan terakhir', 'PMT Beras Nutrisi & Susu Pertumbuhan'],
            ['Rayhan Al-Ghazali', '3202141112230011', '2023-12-11', 'L', 'Rina Agustina', 'Galih Permana', '02', '02', 9.5, 79.5, 45.5, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Anggrek 2', 'Berat dan tinggi seimbang sesuai usia', 'Pemantauan berkala'],
            ['Almira Kanza', '3202144701240012', '2024-01-17', 'P', 'Kokom Komalasari', 'Ahmad Sudrajat', '01', '01', 8.8, 77.0, 44.8, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Melati 1', 'Imunisasi campak tuntas', 'Suplementasi gizi'],
            ['Gibran Rakabuming', '3202140908230013', '2023-08-09', 'L', 'Eneng Rohaeti', 'Budi Santoso', '01', '01', 10.9, 85.5, 47.0, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Melati 1', 'Motorik kasar dan halus berkembang baik', 'Edukasi pola asuh anak'],
            ['Syifa Fauziah', '3202145303240014', '2024-03-15', 'P', 'Lilis Karlina', 'Yayan Hendriyana', '02', '01', 6.8, 69.5, 41.8, 'Gizi Buruk', 'Sangat Pendek (Severely Stunted)', 'Posyandu Mawar 2', 'Berat badan dan tinggi badan jauh di bawah garis merah', 'Rujukan prioritas ke RSUD Sekarwangi & PMT F-100'],
            ['Haikal Kamil', '3202142909230015', '2023-09-29', 'L', 'Aan Rohanah', 'Samsudin', '03', '01', 11.2, 86.0, 46.8, 'Gizi Baik (Normal)', 'Normal', 'Posyandu Kenanga 3', 'Kondisi kesehatan stabil', 'Pemberian obat cacing tahunan'],
        ];

        foreach ($stuntingData as $st) {
            Stunting::create([
                'nama_anak' => $st[0],
                'nik_anak' => $st[1],
                'tanggal_lahir' => Carbon::parse($st[2]),
                'jenis_kelamin' => $st[3],
                'nama_ibu' => $st[4],
                'nama_ayah' => $st[5],
                'rt' => $st[6],
                'rw' => $st[7],
                'berat_badan' => $st[8],
                'tinggi_badan' => $st[9],
                'lingkar_kepala' => $st[10],
                'status_gizi' => $st[11],
                'status_stunting' => $st[12],
                'tanggal_pemeriksaan' => Carbon::now()->subDays(rand(2, 28)),
                'posyandu_nama' => $st[13],
                'catatan_kader' => $st[14],
                'intervensi_diberikan' => $st[15],
                'kader_id' => $kader->id,
            ]);
        }

        // ==========================================
        // 4. DATA PINDAH KAMPUNG & KEMATIAN WARGA
        // ==========================================
        // Data Pindah 1: Menunggu Persetujuan Kades (untuk live demo)
        PindahWarga::create([
            'penduduk_id' => $pendudukModels[12]->id, // Hendra Gunawan
            'no_surat_pengantar' => '475/012/RT01-RW01/X/2026',
            'alamat_tujuan' => 'Jl. Pahlawan No. 45, RT 03/RW 02',
            'rt_tujuan' => '03',
            'rw_tujuan' => '02',
            'desa_kelurahan_tujuan' => 'Cikole',
            'kecamatan_tujuan' => 'Cikole',
            'kabupaten_kota_tujuan' => 'Kota Sukabumi',
            'provinsi_tujuan' => 'Jawa Barat',
            'alasan_pindah' => 'Pekerjaan (Pindah Kantor Baru)',
            'tanggal_pindah' => Carbon::now()->addDays(5),
            'jumlah_keluarga_pindah' => 2,
            'status_pengajuan' => 'menunggu',
            'catatan_kades' => null,
            'diajukan_oleh_user_id' => $rt01->id,
        ]);

        // Data Pindah 2: Sudah Disetujui Kades
        $pindah2 = PindahWarga::create([
            'penduduk_id' => $pendudukModels[39]->id, // Rian Hidayat
            'no_surat_pengantar' => '475/008/RT02-RW02/IX/2026',
            'alamat_tujuan' => 'Jl. Gegerkalong Hilir No. 80',
            'rt_tujuan' => '04',
            'rw_tujuan' => '03',
            'desa_kelurahan_tujuan' => 'Sukasari',
            'kecamatan_tujuan' => 'Sukasari',
            'kabupaten_kota_tujuan' => 'Kota Bandung',
            'provinsi_tujuan' => 'Jawa Barat',
            'alasan_pindah' => 'Pendidikan Lanjutan S2',
            'tanggal_pindah' => Carbon::now()->subMonths(1),
            'jumlah_keluarga_pindah' => 1,
            'status_pengajuan' => 'disetujui',
            'catatan_kades' => 'Berkas persyaratan lengkap, surat pindah telah diterbitkan.',
            'diajukan_oleh_user_id' => $rt02->id,
            'disetujui_oleh_user_id' => $kades->id,
            'disetujui_at' => Carbon::now()->subMonths(1),
        ]);
        // Update status penduduk terkait menjadi pindah
        $pendudukModels[39]->update(['status_dasar' => 'pindah']);

        // Data Kematian 1: Menunggu Persetujuan Kades (untuk live demo)
        KematianWarga::create([
            'penduduk_id' => $pendudukModels[6]->id, // Abah Mansyur
            'tanggal_kematian' => Carbon::now()->subDays(2),
            'waktu_kematian' => '04.30 WIB',
            'tempat_kematian' => 'Rumah Duka Gang Saluyu No. 01',
            'sebab_kematian' => 'Sakit Usia Lanjut / Menua',
            'nama_pelapor' => 'Ahmad Sudrajat',
            'hubungan_pelapor' => 'Tetangga Dekat & Keluarga',
            'status_pengajuan' => 'menunggu',
            'catatan_kades' => null,
            'diajukan_oleh_user_id' => $rt01->id,
        ]);

        // ==========================================
        // 5. DATA LAYANAN KTP HILANG (4-Langkah Alur)
        // ==========================================
        // 1. Pengajuan Baru oleh Warga (Langkah 1)
        KtpHilang::create([
            'kode_lacak' => 'KTP-202610-A19F',
            'nik_pemohon' => '3202140404030006',
            'nama_pemohon' => 'Fajar Ramadhan',
            'tempat_lahir' => 'Sukabumi',
            'tanggal_lahir' => Carbon::parse('2003-04-04'),
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'no_hp' => '0813-9988-7766',
            'alamat' => 'Jl. Sukaraja No. 04',
            'rt' => '01',
            'rw' => '01',
            'lokasi_kehilangan' => 'Pasar Tradisional Kebonpedes',
            'tanggal_kehilangan' => Carbon::now()->subDays(2),
            'kronologi' => 'Dompet terjatuh di sekitar los sayur pasar saat berbelanja bahan baku.',
            'status' => 'diajukan',
            'opt_in_persetujuan' => true,
        ]);

        // 2. Diverifikasi RT (Langkah 2 - Menunggu Persetujuan Kades)
        KtpHilang::create([
            'kode_lacak' => 'KTP-202610-B88D',
            'nik_pemohon' => '3202141708960022',
            'nama_pemohon' => 'Agus Setiawan',
            'tempat_lahir' => 'Sukabumi',
            'tanggal_lahir' => Carbon::parse('1996-08-17'),
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'pekerjaan' => 'Mekanik Bengkel',
            'no_hp' => '0858-1122-3344',
            'alamat' => 'Jl. Pesantren No. 14',
            'rt' => '02',
            'rw' => '01',
            'lokasi_kehilangan' => 'Jalan Raya Sukaraja - Sukabumi',
            'tanggal_kehilangan' => Carbon::now()->subDays(4),
            'kronologi' => 'KTP terjatuh dari saku jaket saat berkendara sepeda motor.',
            'status' => 'verifikasi_rt',
            'catatan_rt' => 'Data pemohon terdaftar sah sebagai warga RT 02 / RW 01 dan dokumen fotokopi KK terverifikasi.',
            'verified_rt_by' => $rt02->id,
            'verified_rt_at' => Carbon::now()->subDays(3),
            'opt_in_persetujuan' => true,
        ]);

        // 3. Surat Keterangan Siap / Selesai (Langkah 4 - Siap Cetak PDF)
        KtpHilang::create([
            'kode_lacak' => 'KTP-202610-C99Z',
            'nik_pemohon' => '3202141208050003',
            'nama_pemohon' => 'Rizky Sudrajat',
            'tempat_lahir' => 'Sukabumi',
            'tanggal_lahir' => Carbon::parse('2005-08-12'),
            'jenis_kelamin' => 'L',
            'agama' => 'Islam',
            'pekerjaan' => 'Pelajar / Mahasiswa',
            'no_hp' => '0877-4455-6677',
            'alamat' => 'Kp. Kebonpedes Girang No. 12',
            'rt' => '01',
            'rw' => '01',
            'lokasi_kehilangan' => 'Kawasan Kampus / Angkutan Umum',
            'tanggal_kehilangan' => Carbon::now()->subDays(7),
            'kronologi' => 'Tas ransel tertinggal di kendaraan umum saat perjalanan pulang.',
            'status' => 'selesai',
            'catatan_rt' => 'Warga asli RT 01/RW 01, berkas pendukung lengkap.',
            'verified_rt_by' => $rt01->id,
            'verified_rt_at' => Carbon::now()->subDays(6),
            'catatan_kades' => 'Permohonan disetujui. Surat Keterangan Pengganti KTP Sementara telah diterbitkan dan ditandatangani.',
            'approved_kades_by' => $kades->id,
            'approved_kades_at' => Carbon::now()->subDays(5),
            'no_surat_keterangan' => '474.2/105/Pem-Des/X/2026',
            'tgl_surat_keterangan' => Carbon::now()->subDays(5),
            'opt_in_persetujuan' => true,
        ]);

        // ==========================================
        // 6. DATA ETALASE PRODUK UMKM (Minimal 8 Produk)
        // ==========================================
        $umkmProducts = [
            [
                'nama_usaha' => 'Keripik Singkong & Pisang Mak Eneng',
                'nama_pemilik' => 'Ibu Eneng Rohaeti',
                'nomor_wa' => '6281234567801',
                'kategori' => 'Makanan & Minuman',
                'nama_produk' => 'Keripik Singkong Pedas Gurih Daun Jeruk',
                'deskripsi' => 'Keripik singkong renyah tanpa bahan pengawet dengan bumbu rempah alami daun jeruk asli perkebunan Kebonpedes.',
                'harga' => 15000,
                'satuan' => 'Bungkus 250gr',
                'lokasi_pasar' => 'Pasar Tradisional Kebonpedes - Blok A No. 12',
                'foto' => 'keripik_singkong.jpg',
                'rt' => '01',
                'rw' => '01',
            ],
            [
                'nama_usaha' => 'Gula Semut & Aren Asli Kebonpedes',
                'nama_pemilik' => 'Pak Ahmad Sudrajat',
                'nomor_wa' => '6281234567802',
                'kategori' => 'Olahan Pangan Lokal',
                'nama_produk' => 'Gula Semut Aren Organik 500gr',
                'deskripsi' => 'Gula aren murni hasil sadapan nira pohon aren perbukitan desa Kebonpedes, rendah indeks glikemik dan wangi alami.',
                'harga' => 28000,
                'satuan' => 'Pouch 500gr',
                'lokasi_pasar' => 'Pasar Tradisional Kebonpedes & Rumah Produksi RT 01',
                'foto' => 'gula_aren.jpg',
                'rt' => '01',
                'rw' => '01',
            ],
            [
                'nama_usaha' => 'Anyaman Bambu Tradisional Saluyu',
                'nama_pemilik' => 'Bapak Kosasih',
                'nomor_wa' => '6281234567803',
                'kategori' => 'Kerajinan Tangan',
                'nama_produk' => 'Bakul Nasi & Besek Bambu Halus',
                'deskripsi' => 'Kerajinan tangan bambu tali pilihan, halus, ramah lingkungan dan cocok untuk wadah hantaran serta kuliner khas Sunda.',
                'harga' => 35000,
                'satuan' => 'Set isi 2 Pcs',
                'lokasi_pasar' => 'Kios Kerajinan Balai Desa & Pasar Minggu',
                'foto' => 'anyaman_bambu.jpg',
                'rt' => '03',
                'rw' => '01',
            ],
            [
                'nama_usaha' => 'Telur Bebek & Asin Gurih Barokah',
                'nama_pemilik' => 'Hendra Gunawan',
                'nomor_wa' => '6281234567804',
                'kategori' => 'Pertanian & Peternakan',
                'nama_produk' => 'Telur Asin Masir Asap Kebonpedes',
                'deskripsi' => 'Telur bebek pilihan dari peternakan herbal, diasap dengan batok kelapa sehingga kuning telur berminyak (masir) dan gurih legit.',
                'harga' => 30000,
                'satuan' => 'Kotak isi 6 Butir',
                'lokasi_pasar' => 'Pasar Tradisional Kebonpedes Los Telur 03',
                'foto' => 'telur_asin.jpg',
                'rt' => '01',
                'rw' => '01',
            ],
            [
                'nama_usaha' => 'Kopi Robusta Lereng Pedes',
                'nama_pemilik' => 'Rian Hidayat',
                'nomor_wa' => '6281234567805',
                'kategori' => 'Makanan & Minuman',
                'nama_produk' => 'Bubuk Kopi Robusta Kebonpedes 200gr',
                'deskripsi' => 'Biji kopi robusta petik merah dengan profil sangrai medium-dark, menghasilkan aroma cokelat karamel dan rasa tebal khas Sukabumi.',
                'harga' => 25000,
                'satuan' => 'Pack 200gr',
                'lokasi_pasar' => 'Kedai Kopi Warga & Pasar Kebonpedes',
                'foto' => 'kopi_robusta.jpg',
                'rt' => '02',
                'rw' => '02',
            ],
            [
                'nama_usaha' => 'Madu Murni Randu & Hutan Kebonpedes',
                'nama_pemilik' => 'Budi Santoso',
                'nomor_wa' => '6281234567806',
                'kategori' => 'Olahan Pangan Lokal',
                'nama_produk' => 'Madu Murni Nektar Bunga Randu 350ml',
                'deskripsi' => 'Madu mentah asli 100% tanpa campuran sirup atau pemanasan buatan. Sangat baik untuk imunitas tubuh balita dan lansia.',
                'harga' => 65000,
                'satuan' => 'Botol 350ml',
                'lokasi_pasar' => 'Pasar Tradisional Kebonpedes Kios Jamu No. 05',
                'foto' => 'madu_murni.jpg',
                'rt' => '01',
                'rw' => '01',
            ],
            [
                'nama_usaha' => 'Penjahit Busana & Gamis Nisa',
                'nama_pemilik' => 'Nisa Nurul Aini',
                'nomor_wa' => '6281234567807',
                'kategori' => 'Jasa & Konveksi',
                'nama_produk' => 'Mukena Katun Bordir Manual Cantik',
                'deskripsi' => 'Mukena adem dengan jahitan rapi dan motif bordir manual khas pedesaan, nyaman untuk ibadah harian.',
                'harga' => 120000,
                'satuan' => 'Set Mukena + Tas',
                'lokasi_pasar' => 'Rumah Jahit RT 02 / RW 01',
                'foto' => 'mukena_bordir.jpg',
                'rt' => '02',
                'rw' => '01',
            ],
            [
                'nama_usaha' => 'Sayur Mayur Segar Hidroponik & Kebun',
                'nama_pemilik' => 'Yayan Hendriyana',
                'nomor_wa' => '6281234567808',
                'kategori' => 'Pertanian & Peternakan',
                'nama_produk' => 'Paket Sayur Segar Sop & Lodeh Sehat',
                'deskripsi' => 'Paket aneka sayur segar dipetik pagi hari langsung dari lahan kebun warga RT 02: bayam, kangkung, wortel, dan tomat organik.',
                'harga' => 10000,
                'satuan' => 'Paket 1 Keranjang',
                'lokasi_pasar' => 'Pasar Tradisional Kebonpedes Los Sayur 1-2',
                'foto' => 'sayur_segar.jpg',
                'rt' => '02',
                'rw' => '01',
            ],
        ];

        foreach ($umkmProducts as $u) {
            Umkm::create($u);
        }

        // ==========================================
        // 7. DATA PAPAN KEGIATAN GOTONG ROYONG (Minimal 5 Data)
        // ==========================================
        $kegiatans = [
            [
                'judul' => 'Kerja Bakti Bersih Saluran Air & Selokan Desa',
                'kategori' => 'Kerja Bakti Lingkungan',
                'deskripsi' => 'Gotong royong membersihkan endapan lumpur dan sampah pada saluran irigasi utama guna mencegah banjir musim hujan dan sarang nyamuk DBD.',
                'lokasi' => 'Sepanjang Jalan Utama RT 01 s/d RT 03 RW 01',
                'tanggal_kegiatan' => Carbon::now()->addDays(3),
                'jam_kegiatan' => '07.00 - 11.00 WIB',
                'kuota_relawan' => 30,
                'kontak_pj' => 'Bapak Cecep Supriatna (Ketua RT 01)',
                'no_wa_pj' => '081322334455',
                'status' => 'Akan Datang',
            ],
            [
                'judul' => 'Pekan Posyandu Balita Sehat & Penimbangan Serentak',
                'kategori' => 'Posyandu & Balita Sehat',
                'deskripsi' => 'Pemeriksaan rutin tumbuh kembang anak, penimbangan berat badan, pengukuran tinggi badan, pemberian vitamin A, dan pembagian makanan tambahan (PMT).',
                'lokasi' => 'Balai Posyandu Melati RT 01 RW 01',
                'tanggal_kegiatan' => Carbon::now()->addDays(6),
                'jam_kegiatan' => '08.00 - 12.00 WIB',
                'kuota_relawan' => 15,
                'kontak_pj' => 'Ibu Hj. Siti Nurhaliza',
                'no_wa_pj' => '085799881122',
                'status' => 'Akan Datang',
            ],
            [
                'judul' => 'Santunan Sembako & Lansia Dhuafa Kebonpedes',
                'kategori' => 'Santunan Warga',
                'deskripsi' => 'Penyaluran beras zakat dan paket nutrisi untuk 40 warga lanjut usia dan keluarga pra-sejahtera hasil gotong royong sedekah warga desa.',
                'lokasi' => 'Aula Serbaguna Kantor Balai Desa',
                'tanggal_kegiatan' => Carbon::now()->addDays(10),
                'jam_kegiatan' => '09.00 - 12.30 WIB',
                'kuota_relawan' => 20,
                'kontak_pj' => 'Bapak Ujang Suherman',
                'no_wa_pj' => '081355667788',
                'status' => 'Akan Datang',
            ],
            [
                'judul' => 'Pelatihan Digitalisasi Pemasaran UMKM Desa',
                'kategori' => 'Pelatihan UMKM',
                'deskripsi' => 'Workshop fotografi produk sederhana dengan smartphone dan pembuatan katalog WhatsApp Bisnis untuk para pelaku UMKM pasar desa.',
                'lokasi' => 'Ruang Rapat Kantor Desa Kebonpedes',
                'tanggal_kegiatan' => Carbon::now()->subDays(5),
                'jam_kegiatan' => '13.00 - 16.00 WIB',
                'kuota_relawan' => 25,
                'kontak_pj' => 'Rian Hidayat (Karang Taruna)',
                'no_wa_pj' => '081234567805',
                'status' => 'Selesai',
            ],
            [
                'judul' => 'Rembug Warga & Sosialisasi Layanan Surat Online Desa',
                'kategori' => 'Rembug Warga',
                'deskripsi' => 'Musyawarah warga bersama Kepala Desa dan Ketua RT/RW terkait pengenalan Sistem Informasi Desa, transparansi data, dan layanan surat KTP hilang.',
                'lokasi' => 'Pendopo Kantor Desa Kebonpedes',
                'tanggal_kegiatan' => Carbon::now()->subDays(12),
                'jam_kegiatan' => '19.30 - 21.30 WIB',
                'kuota_relawan' => 50,
                'kontak_pj' => 'Sekretaris Desa Kebonpedes',
                'no_wa_pj' => '081234567890',
                'status' => 'Selesai',
            ],
        ];

        foreach ($kegiatans as $kg) {
            $createdKegiatan = Kegiatan::create($kg);
            // Tambahkan relawan contoh
            RelawanKegiatan::create([
                'kegiatan_id' => $createdKegiatan->id,
                'nama_relawan' => 'Fajar Ramadhan',
                'no_wa' => '081399887766',
                'rt' => '01',
                'rw' => '01',
                'pesan_dukungan' => 'Siap bantu angkut peralatan dan kebersihan!',
                'status_kehadiran' => 'Terdaftar',
            ]);
            RelawanKegiatan::create([
                'kegiatan_id' => $createdKegiatan->id,
                'nama_relawan' => 'Agus Setiawan',
                'no_wa' => '085811223344',
                'rt' => '02',
                'rw' => '01',
                'pesan_dukungan' => 'Semoga kerja bakti berjalan lancar dan kompak.',
                'status_kehadiran' => 'Terdaftar',
            ]);
        }

        // ==========================================
        // 8. DATA PANDUAN PENGGUNAAN & GLOSARIUM
        // ==========================================
        $panduans = [
            [
                'judul' => 'Panduan Masuk Sistem & Memilih Menu bagi Ketua RT/RW',
                'slug' => 'panduan-login-rt-rw',
                'kategori' => 'Panduan Penggunaan',
                'icon' => 'user-circle',
                'ringkasan' => 'Langkah mudah masuk akun, melihat data warga di RT masing-masing, dan memverifikasi pengajuan surat.',
                'konten' => '
<h3>Langkah-langkah Penggunaan:</h3>
<ol>
  <li>Buka halaman <strong>Masuk Akun Perangkat</strong> di pojok kanan atas.</li>
  <li>Pilih tombol <strong>Ketua RT 01</strong> atau masukkan email dan kata sandi Anda.</li>
  <li>Setelah masuk, Anda akan melihat <strong>Dashboard RT</strong> yang menampilkan jumlah warga dan permohonan yang menunggu.</li>
  <li>Untuk menambah data warga baru, klik menu <strong>Data Penduduk</strong> &rarr; klik tombol hijau <strong>+ Tambah Warga Baru</strong>.</li>
  <li>Isi formulir dengan teliti, pastikan mencentang persetujuan warga, lalu klik <strong>Simpan Data</strong>.</li>
</ol>',
                'target_peran' => 'Ketua RT/RW',
                'urutan' => 1,
            ],
            [
                'judul' => 'Panduan Pencatatan Tumbuh Kembang & Stunting Balita untuk Kader',
                'slug' => 'panduan-kader-posyandu',
                'kategori' => 'Panduan Penggunaan',
                'icon' => 'heart',
                'ringkasan' => 'Cara mencatat penimbangan, pengukuran tinggi badan, dan membaca badge status gizi balita.',
                'konten' => '
<h3>Petunjuk Kader Posyandu:</h3>
<ul>
  <li>Masuk menggunakan akun <strong>Kader Posyandu</strong>.</li>
  <li>Pilih menu <strong>Data Stunting & Gizi</strong>.</li>
  <li>Klik tombol <strong>+ Catat Pemeriksaan Balita</strong> saat hari Posyandu.</li>
  <li>Masukkan Berat Badan (kg) dan Tinggi Badan (cm). Sistem secara otomatis menghitung usia bulan dan menentukan status gizi.</li>
  <li>Badge warna Merah menandakan <strong>Sangat Pendek / Stunting</strong> yang perlu segera dikoordinasikan dengan Bidan Desa.</li>
</ul>',
                'target_peran' => 'Kader Posyandu',
                'urutan' => 2,
            ],
            [
                'judul' => 'Panduan Persetujuan Surat & Verifikasi oleh Kepala Desa',
                'slug' => 'panduan-kepala-desa',
                'kategori' => 'Panduan Penggunaan',
                'icon' => 'document-check',
                'ringkasan' => 'Cara memeriksa pengajuan surat pindah, surat kematian, dan surat keterangan kehilangan KTP.',
                'konten' => '
<h3>Alur Verifikasi Kepala Desa:</h3>
<ol>
  <li>Kepala Desa melihat daftar antrean pengajuan pada kartu <strong>Perlu Persetujuan</strong> di Dashboard Utama.</li>
  <li>Klik permohonan untuk meninjau riwayat warga dan catatan dari Ketua RT.</li>
  <li>Klik tombol hijau <strong>Setujui & Terbitkan Surat</strong> atau tombol merah <strong>Tolak</strong> jika data belum sesuai.</li>
  <li>Nomor surat resmi akan otomatis digenerate dan warga dapat mengunduh surat resmi secara daring.</li>
</ol>',
                'target_peran' => 'Kepala Desa',
                'urutan' => 3,
            ],
            [
                'judul' => 'Glosarium Istilah Penting dalam Sistem Informasi Desa',
                'slug' => 'glosarium-istilah-desa',
                'kategori' => 'Glosarium Desa',
                'icon' => 'book-open',
                'ringkasan' => 'Penjelasan istilah umum seperti NIK, KK, Stunting, Dashboard, Masking Data, dan Audit Log.',
                'konten' => '
<dl class="space-y-4">
  <dt class="font-bold text-emerald-800 text-lg">1. NIK (Nomor Induk Kependudukan)</dt>
  <dd class="text-slate-700">Nomor identitas unik 16 digit yang dimiliki setiap penduduk Indonesia. Dalam sistem ini, NIK disamarkan untuk menjaga kerahasiaan data pribadi sesuai UU Perlindungan Data Pribadi.</dd>
  <dt class="font-bold text-emerald-800 text-lg">2. Stunting & Status Gizi</dt>
  <dd class="text-slate-700">Kondisi gagal tumbuh pada anak balita akibat kekurangan gizi kronis, sehingga anak terlalu pendek untuk usianya. Pencegahan stunting mendukung target global SDG 2 (Tanpa Kelaparan) dan SDG 3 (Kesehatan).</dd>
  <dt class="font-bold text-emerald-800 text-lg">3. Dashboard</dt>
  <dd class="text-slate-700">Halaman papan informasi utama yang merangkum angka statistik terpenting, grafik tren, dan pengingat tugas dalam bentuk visual yang mudah dibaca.</dd>
  <dt class="font-bold text-emerald-800 text-lg">4. Audit Log (Riwayat Aktivitas)</dt>
  <dd class="text-slate-700">Catatan otomatis yang merekam setiap aktivitas penambahan, pengubahan, atau penghapusan data untuk menjamin akuntabilitas aparatur desa.</dd>
</dl>',
                'target_peran' => 'Semua',
                'urutan' => 4,
            ],
            [
                'judul' => 'Panduan Fitur Aksesibilitas & Kenyamanan Pengguna Lansia',
                'slug' => 'panduan-aksesibilitas-lansia',
                'kategori' => 'Fitur Aksesibilitas',
                'icon' => 'sparkles',
                'ringkasan' => 'Fitur pengatur ukuran teks, mode kontras tinggi, dan tata letak ramah mata.',
                'konten' => '
<h3>Fitur Aksesibilitas Unggulan:</h3>
<ul>
  <li><strong>Perbesar Ukuran Huruf:</strong> Gunakan tombol "Huruf: Normal / Sedang / Besar" di pojok atas agar teks nyaman dibaca tanpa kacamata.</li>
  <li><strong>Mode Kontras Tinggi:</strong> Memperjelas batas tombol dan kontras teks bagi pengguna dengan daya penglihatan terbatas.</li>
  <li><strong>Tombol Bantuan Ramah:</strong> Tombol hijau melayang "Butuh Bantuan?" siap memberikan penjelasan langsung di setiap halaman.</li>
</ul>',
                'target_peran' => 'Semua',
                'urutan' => 5,
            ],
        ];

        foreach ($panduans as $pnd) {
            Panduan::create($pnd);
        }

        // ==========================================
        // 9. AUDIT LOG AWAL (Sistem Transparansi & Etika)
        // ==========================================
        AuditLog::create([
            'user_id' => $kades->id,
            'user_name' => $kades->name,
            'user_role' => 'Kepala Desa',
            'aksi' => 'INISIALISASI_SISTEM',
            'modul' => 'Sistem',
            'deskripsi' => 'Inisialisasi sistem database kependudukan, kesehatan posyandu, dan etalase UMKM Desa Kebonpedes.',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
            'created_at' => Carbon::now()->subDays(10),
        ]);

        AuditLog::create([
            'user_id' => $rt01->id,
            'user_name' => $rt01->name,
            'user_role' => 'Ketua RT 01 / RW 01',
            'aksi' => 'TAMBAH_DATA',
            'modul' => 'Penduduk',
            'deskripsi' => 'Pencatatan data warga baru (Ahmad Sudrajat - RT 01/RW 01) dengan persetujuan eksplisit (opt-in).',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
            'created_at' => Carbon::now()->subDays(5),
        ]);

        AuditLog::create([
            'user_id' => $kader->id,
            'user_name' => $kader->name,
            'user_role' => 'Kader Posyandu',
            'aksi' => 'TAMBAH_DATA',
            'modul' => 'Stunting',
            'deskripsi' => 'Pencatatan hasil penimbangan & tinggi badan balita Posyandu Melati 1 (Muhammad Alif Pratama).',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
            'created_at' => Carbon::now()->subDays(3),
        ]);
    }
}
