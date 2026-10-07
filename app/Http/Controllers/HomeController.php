<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Stunting;
use App\Models\Umkm;
use App\Models\Kegiatan;
use App\Models\KtpHilang;
use App\Models\Panduan;

class HomeController extends Controller
{
    /**
     * Beranda Publik Utama Desa Kebonpedes
     */
    public function index()
    {
        // Statistik Agregat Non-Rahasia dari Database
        $totalPenduduk = Penduduk::where('status_dasar', 'hidup')->count();
        $totalLaki = Penduduk::where('status_dasar', 'hidup')->where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Penduduk::where('status_dasar', 'hidup')->where('jenis_kelamin', 'P')->count();
        $totalKk = Penduduk::where('status_dasar', 'hidup')->distinct('no_kk')->count('no_kk');
        
        $totalBalita = Stunting::count();
        $totalBalitaNormal = Stunting::where('status_stunting', 'Normal')->count();
        
        $totalUmkm = Umkm::where('is_aktif', true)->count();
        $featuredUmkms = Umkm::where('is_aktif', true)->latest()->take(4)->get();
        
        $kegiatans = Kegiatan::where('status', '!=', 'Selesai')
            ->orderBy('tanggal_kegiatan', 'asc')
            ->take(3)
            ->get();

        $totalSuratKtp = KtpHilang::where('status', 'selesai')->count();
        $panduanUtama = Panduan::where('is_aktif', true)->orderBy('urutan')->take(3)->get();

        return view('home', compact(
            'totalPenduduk',
            'totalLaki',
            'totalPerempuan',
            'totalKk',
            'totalBalita',
            'totalBalitaNormal',
            'totalUmkm',
            'featuredUmkms',
            'kegiatans',
            'totalSuratKtp',
            'panduanUtama'
        ));
    }

    /**
     * Halaman Kebijakan Privasi & Perlindungan Data Pribadi (Etika Profesi)
     */
    public function kebijakanPrivasi()
    {
        return view('pages.kebijakan-privasi');
    }

    /**
     * Halaman Keterkaitan SDGs (Sustainable Development Goals)
     */
    public function tentangSdgs()
    {
        return view('pages.tentang-sdgs');
    }
}
