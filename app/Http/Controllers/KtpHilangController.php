<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KtpHilang;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KtpHilangController extends Controller
{
    public function index()
    {
        $totalPengajuan = KtpHilang::count();
        $totalSelesai = KtpHilang::where('status', 'selesai')->count();
        $pengajuanTerbaru = KtpHilang::latest()->take(5)->get();

        return view('ktp-hilang.index', compact('totalPengajuan', 'totalSelesai', 'pengajuanTerbaru'));
    }

    public function create()
    {
        return view('ktp-hilang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'nik_pemohon' => 'required|digits:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'lokasi_kehilangan' => 'required|string',
            'tanggal_kehilangan' => 'required|date',
            'kronologi' => 'required|string',
            'opt_in_persetujuan' => 'accepted',
        ], [
            'nik_pemohon.digits' => 'NIK harus berjumlah 16 digit.',
            'opt_in_persetujuan.accepted' => 'Persetujuan pemrosesan data (Opt-in) wajib dicentang.',
        ]);

        // Generate Kode Lacak Unik: KTP-202610-XXXX
        $kodeLacak = 'KTP-' . date('Ym') . '-' . strtoupper(Str::random(4));
        $validated['kode_lacak'] = $kodeLacak;
        $validated['status'] = 'diajukan';
        $validated['opt_in_persetujuan'] = true;

        $ktp = KtpHilang::create($validated);

        AuditLog::record(
            'AJUKAN_KTP_HILANG',
            'KTP Hilang',
            "Warga {$ktp->nama_pemohon} mengajukan surat KTP hilang dengan kode lacak: {$kodeLacak}"
        );

        return redirect()->route('ktp-hilang.lacak', ['kode_lacak' => $kodeLacak])
            ->with('success', "Pengajuan berhasil dikirim! Simpan Kode Lacak Anda: {$kodeLacak} untuk memantau proses verifikasi.");
    }

    public function lacak(Request $request)
    {
        $hasilLacak = null;
        $kodeInput = $request->query('kode_lacak');

        if ($kodeInput) {
            $hasilLacak = KtpHilang::where('kode_lacak', trim(strtoupper($kodeInput)))->first();
        }

        return view('ktp-hilang.lacak', compact('hasilLacak', 'kodeInput'));
    }

    public function cetak(int $id)
    {
        $ktp = KtpHilang::findOrFail($id);
        return view('ktp-hilang.cetak', compact('ktp'));
    }

    public function verifyRt(Request $request, int $id)
    {
        $user = Auth::user();
        $ktp = KtpHilang::findOrFail($id);

        $ktp->update([
            'status' => 'verifikasi_rt',
            'catatan_rt' => $request->catatan_rt ?? 'Data pemohon sah terdaftar di RT setempat.',
            'verified_rt_by' => $user->id,
            'verified_rt_at' => now(),
        ]);

        AuditLog::record(
            'VERIFIKASI_RT_KTP',
            'KTP Hilang',
            "Ketua RT {$user->name} memverifikasi pengajuan KTP hilang: {$ktp->kode_lacak} ({$ktp->nama_pemohon})"
        );

        return back()->with('success', "Pengajuan {$ktp->kode_lacak} berhasil diverifikasi dan diteruskan ke Kepala Desa.");
    }

    public function approveKades(Request $request, int $id)
    {
        $user = Auth::user();
        $ktp = KtpHilang::findOrFail($id);

        $noSurat = '474.2/' . str_pad(rand(101, 999), 3, '0', STR_PAD_LEFT) . '/Pem-Des/' . date('m/Y');

        $ktp->update([
            'status' => 'selesai',
            'catatan_kades' => 'Permohonan disetujui. Surat Keterangan Kehilangan KTP telah diterbitkan.',
            'approved_kades_by' => $user->id,
            'approved_kades_at' => now(),
            'no_surat_keterangan' => $noSurat,
            'tgl_surat_keterangan' => now(),
        ]);

        AuditLog::record(
            'TERBITKAN_SURAT_KTP',
            'KTP Hilang',
            "Kepala Desa menyetujui & menerbitkan surat KTP hilang No: {$noSurat} untuk {$ktp->nama_pemohon}"
        );

        return back()->with('success', "Surat Keterangan No {$noSurat} berhasil diterbitkan! Warga dapat mengunduh surat resmi.");
    }

    public function reject(Request $request, int $id)
    {
        $ktp = KtpHilang::findOrFail($id);
        $ktp->update([
            'status' => 'ditolak',
            'catatan_kades' => $request->catatan ?? 'Dokumen atau data yang diajukan tidak sesuai.',
        ]);

        AuditLog::record(
            'TOLAK_KTP_HILANG',
            'KTP Hilang',
            "Pengajuan surat KTP hilang {$ktp->kode_lacak} ditolak."
        );

        return back()->with('info', "Pengajuan surat telah ditolak.");
    }
}
