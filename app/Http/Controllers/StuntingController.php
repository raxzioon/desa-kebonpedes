<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stunting;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class StuntingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Stunting::query();

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_anak', 'like', "%{$keyword}%")
                  ->orWhere('nama_ibu', 'like', "%{$keyword}%")
                  ->orWhere('posyandu_nama', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status_stunting')) {
            $query->where('status_stunting', $request->status_stunting);
        }

        if ($request->filled('rt')) {
            $query->where('rt', $request->rt);
        }

        $stuntings = $query->orderBy('tanggal_pemeriksaan', 'desc')->paginate(10)->withQueryString();

        return view('stunting.index', compact('stuntings', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('stunting.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'nik_anak' => 'nullable|digits:16',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'berat_badan' => 'required|numeric|min:1|max:40',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
            'lingkar_kepala' => 'nullable|numeric|min:20|max:80',
            'status_gizi' => 'required|string',
            'status_stunting' => 'required|string',
            'tanggal_pemeriksaan' => 'required|date',
            'posyandu_nama' => 'required|string',
            'catatan_kader' => 'nullable|string',
            'intervensi_diberikan' => 'nullable|string',
        ]);

        $validated['kader_id'] = $user->id;
        $stunting = Stunting::create($validated);

        AuditLog::record(
            'CATAT_STUNTING',
            'Stunting',
            "Mencatat pemeriksaan balita: {$stunting->nama_anak} ({$stunting->status_stunting})",
            null,
            $stunting->toArray()
        );

        return redirect()->route('stunting.index')->with('success', "Data balita {$stunting->nama_anak} berhasil dicatat.");
    }

    public function show(int $id)
    {
        $user = Auth::user();
        $stunting = Stunting::findOrFail($id);
        return view('stunting.show', compact('stunting', 'user'));
    }

    public function edit(int $id)
    {
        $user = Auth::user();
        $stunting = Stunting::findOrFail($id);
        return view('stunting.edit', compact('stunting', 'user'));
    }

    public function update(Request $request, int $id)
    {
        $user = Auth::user();
        $stunting = Stunting::findOrFail($id);

        $validated = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'nik_anak' => 'nullable|digits:16',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_ibu' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'berat_badan' => 'required|numeric|min:1|max:40',
            'tinggi_badan' => 'required|numeric|min:30|max:150',
            'lingkar_kepala' => 'nullable|numeric|min:20|max:80',
            'status_gizi' => 'required|string',
            'status_stunting' => 'required|string',
            'tanggal_pemeriksaan' => 'required|date',
            'posyandu_nama' => 'required|string',
            'catatan_kader' => 'nullable|string',
            'intervensi_diberikan' => 'nullable|string',
        ]);

        $old = $stunting->toArray();
        $stunting->update($validated);

        AuditLog::record(
            'UBAH_STUNTING',
            'Stunting',
            "Memperbarui data balita: {$stunting->nama_anak}",
            $old,
            $stunting->toArray()
        );

        return redirect()->route('stunting.show', $stunting->id)->with('success', "Data balita {$stunting->nama_anak} berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $stunting = Stunting::findOrFail($id);
        $nama = $stunting->nama_anak;
        $stunting->delete();

        AuditLog::record(
            'HAPUS_STUNTING',
            'Stunting',
            "Menghapus data balita: {$nama}"
        );

        return redirect()->route('stunting.index')->with('success', "Data balita {$nama} telah dihapus.");
    }
}
