<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penduduk;
use App\Models\Stunting;
use App\Models\PindahWarga;
use App\Models\KematianWarga;
use App\Models\KtpHilang;
use App\Models\Umkm;
use App\Models\Kegiatan;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan Dashboard Khusus Sesuai Peran Pengguna (RBAC)
     */
    public function index()
    {
        $user = Auth::user();

        // 1. DATA UNTUK PERAN KEPALA DESA (Seluruh Desa)
        if ($user->isKades()) {
            $totalPenduduk = Penduduk::where('status_dasar', 'hidup')->count();
            $totalKk = Penduduk::where('status_dasar', 'hidup')->distinct('no_kk')->count('no_kk');
            $totalBalita = Stunting::count();
            $totalStunting = Stunting::whereIn('status_stunting', ['Sangat Pendek (Severely Stunted)', 'Pendek (Stunted)'])->count();
            $totalUmkm = Umkm::where('is_aktif', true)->count();
            $totalKegiatan = Kegiatan::count();

            // Antrean Pengajuan yang Menunggu Tindakan Kepala Desa
            $antreanPindah = PindahWarga::with('penduduk', 'diajukanOleh')
                ->where('status_pengajuan', 'menunggu')
                ->latest()
                ->get();

            $antreanKematian = KematianWarga::with('penduduk', 'diajukanOleh')
                ->where('status_pengajuan', 'menunggu')
                ->latest()
                ->get();

            $antreanKtp = KtpHilang::where('status', 'verifikasi_rt')
                ->latest()
                ->get();

            $totalMenunggu = $antreanPindah->count() + $antreanKematian->count() + $antreanKtp->count();

            // Data Grafik: Sebaran Penduduk per RT
            $sebaranRt = Penduduk::where('status_dasar', 'hidup')
                ->select('rt', 'rw', DB::raw('count(*) as total'))
                ->groupBy('rt', 'rw')
                ->orderBy('rw')
                ->orderBy('rt')
                ->get();

            $chartRtLabels = $sebaranRt->map(fn($item) => "RT {$item->rt}/RW {$item->rw}")->toArray();
            $chartRtData = $sebaranRt->pluck('total')->toArray();

            // Data Grafik: Status Gizi Balita
            $giziStats = Stunting::select('status_stunting', DB::raw('count(*) as total'))
                ->groupBy('status_stunting')
                ->get();

            $chartGiziLabels = $giziStats->pluck('status_stunting')->toArray();
            $chartGiziData = $giziStats->pluck('total')->toArray();

            // Riwayat Aktivitas Audit Log Terbaru
            $auditLogs = AuditLog::latest('created_at')->take(8)->get();

            return view('dashboard.kades', compact(
                'user',
                'totalPenduduk',
                'totalKk',
                'totalBalita',
                'totalStunting',
                'totalUmkm',
                'totalKegiatan',
                'totalMenunggu',
                'antreanPindah',
                'antreanKematian',
                'antreanKtp',
                'chartRtLabels',
                'chartRtData',
                'chartGiziLabels',
                'chartGiziData',
                'auditLogs'
            ));
        }

        // 2. DATA UNTUK PERAN KETUA RT / RW (Khusus Wilayahnya)
        if ($user->isRtRw()) {
            $myPendudukQuery = Penduduk::wilayah($user);
            $totalPendudukRt = (clone $myPendudukQuery)->where('status_dasar', 'hidup')->count();
            $totalLakiRt = (clone $myPendudukQuery)->where('status_dasar', 'hidup')->where('jenis_kelamin', 'L')->count();
            $totalPerempuanRt = (clone $myPendudukQuery)->where('status_dasar', 'hidup')->where('jenis_kelamin', 'P')->count();
            $totalKkRt = (clone $myPendudukQuery)->where('status_dasar', 'hidup')->distinct('no_kk')->count('no_kk');

            // Pengajuan KTP Hilang dari warga RT miliknya yang butuh verifikasi
            $antreanKtpRt = KtpHilang::where('rt', $user->rt)
                ->where('rw', $user->rw)
                ->where('status', 'diajukan')
                ->latest()
                ->get();

            // Data Warga Terbaru di RT
            $wargaTerbaru = (clone $myPendudukQuery)
                ->where('status_dasar', 'hidup')
                ->latest()
                ->take(6)
                ->get();

            return view('dashboard.rt', compact(
                'user',
                'totalPendudukRt',
                'totalLakiRt',
                'totalPerempuanRt',
                'totalKkRt',
                'antreanKtpRt',
                'wargaTerbaru'
            ));
        }

        // 3. DATA UNTUK PERAN KADER POSYANDU (Kesehatan Balita & Stunting)
        if ($user->isKader()) {
            $totalBalita = Stunting::count();
            $totalNormal = Stunting::where('status_stunting', 'Normal')->count();
            $totalStunted = Stunting::where('status_stunting', 'Pendek (Stunted)')->count();
            $totalSevere = Stunting::where('status_stunting', 'Sangat Pendek (Severely Stunted)')->count();
            $totalTinggi = Stunting::where('status_stunting', 'Tinggi')->count();

            // Balita yang Memerlukan Intervensi / Pendampingan Prioritas
            $balitaPrioritas = Stunting::whereIn('status_stunting', ['Sangat Pendek (Severely Stunted)', 'Pendek (Stunted)'])
                ->latest('tanggal_pemeriksaan')
                ->get();

            // Grafik Chart Status Stunting
            $chartGiziLabels = ['Normal', 'Pendek (Stunted)', 'Sangat Pendek (Severely)', 'Tinggi'];
            $chartGiziData = [$totalNormal, $totalStunted, $totalSevere, $totalTinggi];

            return view('dashboard.kader', compact(
                'user',
                'totalBalita',
                'totalNormal',
                'totalStunted',
                'totalSevere',
                'totalTinggi',
                'balitaPrioritas',
                'chartGiziLabels',
                'chartGiziData'
            ));
        }

        return redirect()->route('home');
    }
}
