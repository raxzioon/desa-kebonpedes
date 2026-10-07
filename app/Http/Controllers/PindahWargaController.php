<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PindahWarga;
use App\Models\Penduduk;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class PindahWargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pindahs = PindahWarga::with('penduduk', 'diajukanOleh', 'disetujuiOleh')
            ->latest()
            ->paginate(10);

        return view('pindah.index', compact('pindahs', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $penduduks = Penduduk::wilayah($user)->where('status_dasar', 'hidup')->orderBy('nama')->get();
        return view('pindah.create', compact('penduduks', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'penduduk_id' => 'required|exists:penduduks,id',
            'alamat_tujuan' => 'required|string',
            'desa_kelurahan_tujuan' => 'required|string',
            'kecamatan_tujuan' => 'required|string',
            'kabupaten_kota_tujuan' => 'required|string',
            'provinsi_tujuan' => 'required|string',
            'alasan_pindah' => 'required|string',
            'tanggal_pindah' => 'required|date',
            'jumlah_keluarga_pindah' => 'required|integer|min:1',
        ]);

        $validated['no_surat_pengantar'] = '475/' . str_pad(rand(10, 999), 3, '0', STR_PAD_LEFT) . '/RT' . ($user->rt ?? '01') . '-RW' . ($user->rw ?? '01') . '/' . date('m/Y');
        $validated['status_pengajuan'] = 'menunggu';
        $validated['diajukan_oleh_user_id'] = $user->id;

        $pindah = PindahWarga::create($validated);
        $warga = Penduduk::find($validated['penduduk_id']);

        AuditLog::record(
            'AJUKAN_PINDAH',
            'Pindah Warga',
            "Mengajukan surat pindah untuk warga: {$warga->nama} menuju {$pindah->kabupaten_kota_tujuan}"
        );

        return redirect()->route('pindah.index')->with('success', "Permohonan pindah untuk {$warga->nama} berhasil diajukan dan menunggu persetujuan Kepala Desa.");
    }

    public function approve(int $id)
    {
        $pindah = PindahWarga::with('penduduk')->findOrFail($id);
        $pindah->update([
            'status_pengajuan' => 'disetujui',
            'disetujui_oleh_user_id' => Auth::id(),
            'disetujui_at' => now(),
            'catatan_kades' => 'Disetujui dan diterbitkan surat pindah resmi.',
        ]);

        // Otomatis ubah status warga jadi 'pindah'
        $pindah->penduduk->update(['status_dasar' => 'pindah']);

        AuditLog::record(
            'SETUJUI_PINDAH',
            'Pindah Warga',
            "Kepala Desa menyetujui surat pindah warga: {$pindah->penduduk->nama}"
        );

        return back()->with('success', "Permohonan surat pindah untuk {$pindah->penduduk->nama} telah disetujui.");
    }

    public function reject(Request $request, int $id)
    {
        $pindah = PindahWarga::with('penduduk')->findOrFail($id);
        $pindah->update([
            'status_pengajuan' => 'ditolak',
            'catatan_kades' => $request->catatan ?? 'Dokumen pendukung belum lengkap.',
        ]);

        AuditLog::record(
            'TOLAK_PINDAH',
            'Pindah Warga',
            "Kepala Desa menolak permohonan pindah warga: {$pindah->penduduk->nama}"
        );

        return back()->with('info', "Permohonan pindah telah ditolak.");
    }
}
