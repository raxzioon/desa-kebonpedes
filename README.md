# Sistem Informasi Desa Kebonpedes (SID)

> **Aplikasi Sistem Informasi Desa Kebonpedes**  
> Tugas Besar Mata Kuliah: Analisis Perancangan Sistem Informasi (APSI), Perancangan Interaksi, dan Etika Profesi — Program Studi S1 Sistem Informasi, Telkom University.

---

## 📌 Gambaran Umum
Sistem Informasi Desa Kebonpedes adalah platform tata kelola administrasi desa, pemantauan kesehatan gizi balita (stunting), etalase usaha mikro warga (UMKM), dan pendaftaran relawan gotong royong yang dirancang khusus dengan memperhatikan kemudahan interaksi bagi pengguna lanjut usia dan kepatuhan terhadap prinsip perlindungan data pribadi (UU PDP / Etika Profesi).

---

## ✨ Fitur Utama
1. **Beranda Publik & Layanan Terbuka**:
   - Statistik agregat kependudukan real-time dari database.
   - Papan agenda kegiatan gotong royong & pendaftaran relawan.
   - Etalase produk UMKM lokal yang terhubung langsung ke WhatsApp pemilik usaha.
   - Pusat panduan, glosarium istilah kependudukan, dan simulasi mode latihan.
2. **Layanan Surat Keterangan KTP Hilang**:
   - Pengajuan surat mandiri oleh warga secara daring.
   - Pelacakan status surat berbasis kode unik tanpa harus login (alur 4 tahap: Pengajuan &rarr; Verifikasi RT/RW &rarr; Persetujuan Kades &rarr; Surat Siap).
   - Cetak surat keterangan resmi dengan format kop surat standar desa.
3. **Pencatatan & Pemantauan Stunting Balita**:
   - Manajemen data gizi anak (BB, TB, Lingkar Kepala, Usia).
   - Klasifikasi otomatis: Normal, Risiko Stunting, Stunting, Gizi Kurang.
4. **Data Kependudukan Scoped RT/RW**:
   - Manajemen data warga dengan pembatasan hak akses berbasis wilayah RT/RW.
   - Penyamaran data sensitif (NIK, tanggal lahir, kontak) sesuai UU PDP.
   - Persetujuan eksplisit (*Explicit Opt-In*) saat penyimpanan data warga.
5. **Pencatatan Pindah Domisili & Kematian**:
   - Alur persetujuan Kepala Desa sebelum status kependudukan diperbarui di database.
6. **Audit Trail & Keamanan (Kepala Desa)**:
   - Pencatatan otomatis setiap aksi perubahan data (siapa, kapan, aktivitas, data lama/baru).
7. **Fitur Aksesibilitas (Ramah Lansia)**:
   - Pengatur ukuran huruf 3 tingkat (A / A+ / A++).
   - Mode Kontras Tinggi (*High Contrast*).
   - Mode Sederhana (*Reduced Motion*).
   - Desain responsif, font terbaca jelas (Inter), target sentuh minimal 48px.

---

## 👥 Akun Demo & Hak Akses (Role-Based Access Control)

| Peran Pengguna | Username / Email | Password | Hak Akses & Wilayah |
| :--- | :--- | :--- | :--- |
| **Kepala Desa** | `kades@kebonpedes.desa.id` | `password` | Akses penuh seluruh data, persetujuan surat/pindah/kematian, audit log, kelola user |
| **Ketua RT 01 / RW 01** | `rt01@kebonpedes.desa.id` | `password` | CRUD data warga, pindah, dan meninggal khusus di wilayah **RT 01 / RW 01** |
| **Ketua RT 02 / RW 01** | `rt02@kebonpedes.desa.id` | `password` | CRUD data warga, pindah, dan meninggal khusus di wilayah **RT 02 / RW 01** |
| **Kader Posyandu** | `kader@kebonpedes.desa.id` | `password` | CRUD data balita, pengukuran tumbuh kembang & status stunting |
| **Masyarakat Umum** | *(Tanpa Login)* | - | Akses beranda, ajukan surat KTP hilang, lacak surat, lihat UMKM, gotong royong, panduan |

---

## 🚀 Petunjuk Menjalankan Aplikasi

### 1. Kebutuhan Sistem
- PHP >= 8.2
- Composer
- Ekstensi PHP: `pdo_sqlite` / `pdo_mysql`, `mbstring`, `fileinfo`, `gd`

### 2. Langkah Instalasi

```bash
# 1. Masuk ke direktori proyek
cd desa-kebonpedes

# 2. Salin environment file
cp .env.example .env

# 3. Instal dependensi PHP
composer install

# 4. Generate Application Key
php artisan key:generate

# 5. Jalankan Migration dan Seeder Data Contoh
php artisan migrate --seed

# 6. Jalankan Server Lokal
php artisan serve
```

Aplikasi dapat diakses melalui browser di: `http://localhost:8000`

---

## 🧪 Menjalankan Pengujian Otomatis (Testing)
Proyek ini dilengkapi dengan suite pengujian otomatis untuk memvalidasi alur bisnis, hak akses RBAC, penyamaran data, dan pelacakan surat:

```bash
php artisan test
```

---

## 📄 Catatan Akademik & Etika Profesi
*Data penduduk, NIK, nama balita, dan nomor telepon yang tercantum dalam aplikasi ini adalah data contoh fiktif yang digunakan khusus untuk keperluan demonstrasi akademik tugas besar S1 Sistem Informasi Telkom University.*
