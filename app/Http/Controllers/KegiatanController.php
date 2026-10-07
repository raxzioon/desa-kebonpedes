<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\RelawanKegiatan;
use App\Models\AuditLog;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $kegiatans = $query->orderBy('tanggal_kegiatan', 'asc')->paginate(6)->withQueryString();
        $kategoris = Kegiatan::select('kategori')->distinct()->pluck('kategori');

        return view('gotong-royong.index', compact('kegiatans', 'kategoris'));
    }

    public function show(int $id)
    {
        $kegiatan = Kegiatan::with('relawans')->findOrFail($id);
        return view('gotong-royong.show', compact('kegiatan'));
    }

    public function daftarRelawan(Request $request, int $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $validated = $request->validate([
            'nama_relawan' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'pesan_dukungan' => 'nullable|string',
        ]);

        $validated['kegiatan_id'] = $kegiatan->id;
        $validated['status_kehadiran'] = 'Terdaftar';

        $relawan = RelawanKegiatan::create($validated);

        AuditLog::record(
            'DAFTAR_RELAWAN',
            'Gotong Royong',
            "Warga {$relawan->nama_relawan} mendaftar relawan pada kegiatan: {$kegiatan->judul}"
        );

        return back()->with('success', "Terima kasih, {$relawan->nama_relawan}! Anda telah terdaftar sebagai relawan. Petugas penanggung jawab akan menghubungi Anda.");
    }
}
