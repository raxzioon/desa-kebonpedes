<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KematianWarga;
use App\Models\Penduduk;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class KematianWargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kematians = KematianWarga::with('penduduk', 'diajukanOleh', 'disetujuiOleh')
            ->latest()
            ->paginate(10);

        return view('kematian.index', compact('kematians', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $penduduks = Penduduk::wilayah($user)->where('status_dasar', 'hidup')->orderBy('nama')->get();
        return view('kematian.create', compact('penduduks', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'tanggal_kematian' => 'required|date',
            'waktu_kematian' => 'nullable|string',
            'tempat_kematian' => 'required|string',
            'sebab_kematian' => 'required|string',
            'nama_pelapor' => 'required|string',
            'hubungan_pelapor' => 'required|string',
        ]);

        $validated['status_pengajuan'] = 'menunggu';
        $validated['diajukan_oleh_user_id'] = $user->id;

        $kematian = KematianWarga::create($validated);
        $warga = Penduduk::find($validated['penduduk_id']);

        AuditLog::record(
            'AJUKAN_KEMATIAN',
            'Kematian',
            "Mencatat laporan kematian warga: {$warga->nama} oleh pelapor {$kematian->nama_pelapor}"
        );

        return redirect()->route('kematian.index')->with('success', "Laporan kematian warga {$warga->nama} berhasil disimpan dan menunggu verifikasi Kepala Desa.");
    }

    public function approve(int $id)
    {
        $kematian = KematianWarga::with('penduduk')->findOrFail($id);
        $kematian->update([
            'status_pengajuan' => 'disetujui',
            'disetujui_oleh_user_id' => Auth::id(),
            'disetujui_at' => now(),
            'catatan_kades' => 'Catatan kematian telah diverifikasi sah.',
        ]);

        // Otomatis ubah status warga jadi 'meninggal'
        $kematian->penduduk->update(['status_dasar' => 'meninggal']);

        AuditLog::record(
            'SETUJUI_KEMATIAN',
            'Kematian',
            "Kepala Desa menyetujui pencatatan kematian warga: {$kematian->penduduk->nama}"
        );

        return back()->with('success', "Pencatatan kematian warga {$kematian->penduduk->nama} telah disetujui.");
    }

    public function reject(Request $request, int $id)
    {
        $kematian = KematianWarga::with('penduduk')->findOrFail($id);
        $kematian->update([
            'status_pengajuan' => 'ditolak',
            'catatan_kades' => $request->catatan ?? 'Keterangan pelapor belum terverifikasi.',
        ]);

        AuditLog::record(
            'TOLAK_KEMATIAN',
            'Kematian',
            "Kepala Desa menolak laporan kematian warga: {$kematian->penduduk->nama}"
        );

        return back()->with('info', "Laporan kematian telah ditolak.");
    }
}
