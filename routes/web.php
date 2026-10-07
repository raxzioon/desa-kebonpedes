<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi Desa Kebonpedes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PUBLIK (DAPAT DIAKSES TANPA LOGIN)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kebijakan-privasi', [HomeController::class, 'kebijakanPrivasi'])->name('kebijakan-privasi');
Route::get('/tentang-sdgs', [HomeController::class, 'tentangSdgs'])->name('tentang-sdgs');

// Layanan Publik: KTP Hilang (Pelacakan & Pengajuan Mandiri Warga)
Route::get('/lapor-ktp-hilang', function () {
    return redirect()->route('ktp-hilang.create');
})->name('lapor-ktp');
Route::get('/ktp-hilang', [\App\Http\Controllers\KtpHilangController::class, 'index'])->name('ktp-hilang.index');
Route::get('/ktp-hilang/buat-permohonan', [\App\Http\Controllers\KtpHilangController::class, 'create'])->name('ktp-hilang.create');
Route::post('/ktp-hilang/simpan', [\App\Http\Controllers\KtpHilangController::class, 'store'])->name('ktp-hilang.store');
Route::get('/ktp-hilang/lacak', [\App\Http\Controllers\KtpHilangController::class, 'lacak'])->name('ktp-hilang.lacak');
Route::get('/ktp-hilang/cetak/{id}', [\App\Http\Controllers\KtpHilangController::class, 'cetak'])->name('ktp-hilang.cetak');

// Layanan Publik: Pasar UMKM Desa
Route::get('/pasar-umkm', [\App\Http\Controllers\UmkmController::class, 'index'])->name('umkm.index');
Route::get('/pasar-umkm/{id}', [\App\Http\Controllers\UmkmController::class, 'show'])->name('umkm.show');

// Layanan Publik: Gotong Royong & Relawan
Route::get('/gotong-royong', [\App\Http\Controllers\KegiatanController::class, 'index'])->name('gotong-royong.index');
Route::get('/gotong-royong/{id}', [\App\Http\Controllers\KegiatanController::class, 'show'])->name('gotong-royong.show');
Route::post('/gotong-royong/{id}/daftar-relawan', [\App\Http\Controllers\KegiatanController::class, 'daftarRelawan'])->name('gotong-royong.daftar-relawan');

// Pusat Panduan, Glosarium & Pelatihan
Route::get('/panduan', [\App\Http\Controllers\PanduanController::class, 'index'])->name('panduan.index');
Route::get('/panduan/latihan-mandiri', [\App\Http\Controllers\PanduanController::class, 'latihan'])->name('panduan.latihan');
Route::get('/panduan/{slug}', [\App\Http\Controllers\PanduanController::class, 'show'])->name('panduan.show');

// ==========================================
// 2. RUTE AUTENTIKASI (MASUK / KELUAR)
// ==========================================
Route::get('/masuk', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/masuk', [AuthController::class, 'login'])->name('login.post');
Route::get('/masuk-demo/{role}', [AuthController::class, 'demoLogin'])->name('login.demo');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// 3. RUTE KHUSUS PERANGKAT DESA (TERAUTENTIKASI)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Dashboard Peran
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Data Penduduk (Kades & RT/RW)
    Route::middleware(['role:kades,rt_rw'])->group(function () {
        Route::get('/data-penduduk', [\App\Http\Controllers\PendudukController::class, 'index'])->name('penduduk.index');
        Route::get('/data-penduduk/tambah', [\App\Http\Controllers\PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('/data-penduduk/simpan', [\App\Http\Controllers\PendudukController::class, 'store'])->name('penduduk.store');
        Route::get('/data-penduduk/{id}', [\App\Http\Controllers\PendudukController::class, 'show'])->name('penduduk.show');
        Route::get('/data-penduduk/{id}/edit', [\App\Http\Controllers\PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::put('/data-penduduk/{id}', [\App\Http\Controllers\PendudukController::class, 'update'])->name('penduduk.update');
        Route::delete('/data-penduduk/{id}', [\App\Http\Controllers\PendudukController::class, 'destroy'])->name('penduduk.destroy');

        // Pindah Kampung & Kematian
        Route::get('/layanan/pindah-warga', [\App\Http\Controllers\PindahWargaController::class, 'index'])->name('pindah.index');
        Route::get('/layanan/pindah-warga/buat', [\App\Http\Controllers\PindahWargaController::class, 'create'])->name('pindah.create');
        Route::post('/layanan/pindah-warga/simpan', [\App\Http\Controllers\PindahWargaController::class, 'store'])->name('pindah.store');
        Route::post('/layanan/pindah-warga/{id}/setujui', [\App\Http\Controllers\PindahWargaController::class, 'approve'])->name('pindah.approve')->middleware('role:kades');
        Route::post('/layanan/pindah-warga/{id}/tolak', [\App\Http\Controllers\PindahWargaController::class, 'reject'])->name('pindah.reject')->middleware('role:kades');

        Route::get('/layanan/kematian-warga', [\App\Http\Controllers\KematianWargaController::class, 'index'])->name('kematian.index');
        Route::get('/layanan/kematian-warga/buat', [\App\Http\Controllers\KematianWargaController::class, 'create'])->name('kematian.create');
        Route::post('/layanan/kematian-warga/simpan', [\App\Http\Controllers\KematianWargaController::class, 'store'])->name('kematian.store');
        Route::post('/layanan/kematian-warga/{id}/setujui', [\App\Http\Controllers\KematianWargaController::class, 'approve'])->name('kematian.approve')->middleware('role:kades');
        Route::post('/layanan/kematian-warga/{id}/tolak', [\App\Http\Controllers\KematianWargaController::class, 'reject'])->name('kematian.reject')->middleware('role:kades');

        // Verifikasi KTP Hilang (RT / Kades)
        Route::post('/ktp-hilang/{id}/verifikasi-rt', [\App\Http\Controllers\KtpHilangController::class, 'verifyRt'])->name('ktp-hilang.rt-verify')->middleware('role:kades,rt_rw');
        Route::post('/ktp-hilang/{id}/setujui-kades', [\App\Http\Controllers\KtpHilangController::class, 'approveKades'])->name('ktp-hilang.kades-approve')->middleware('role:kades');
        Route::post('/ktp-hilang/{id}/tolak', [\App\Http\Controllers\KtpHilangController::class, 'reject'])->name('ktp-hilang.reject')->middleware('role:kades,rt_rw');
    });

    // Modul Data Stunting & Balita (Kades & Kader Posyandu)
    Route::middleware(['role:kades,kader'])->group(function () {
        Route::get('/data-stunting', [\App\Http\Controllers\StuntingController::class, 'index'])->name('stunting.index');
        Route::get('/data-stunting/tambah', [\App\Http\Controllers\StuntingController::class, 'create'])->name('stunting.create');
        Route::post('/data-stunting/simpan', [\App\Http\Controllers\StuntingController::class, 'store'])->name('stunting.store');
        Route::get('/data-stunting/{id}', [\App\Http\Controllers\StuntingController::class, 'show'])->name('stunting.show');
        Route::get('/data-stunting/{id}/edit', [\App\Http\Controllers\StuntingController::class, 'edit'])->name('stunting.edit');
        Route::put('/data-stunting/{id}', [\App\Http\Controllers\StuntingController::class, 'update'])->name('stunting.update');
        Route::delete('/data-stunting/{id}', [\App\Http\Controllers\StuntingController::class, 'destroy'])->name('stunting.destroy');
    });

    // Modul Audit Log & Manajemen Akun (Khusus Kepala Desa)
    Route::middleware(['role:kades'])->group(function () {
        Route::get('/audit-log', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit-log.index');
    });
});
