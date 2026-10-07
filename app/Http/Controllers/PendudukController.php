<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Penduduk::wilayah($user);

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                  ->orWhere('nik', 'like', "%{$keyword}%")
                  ->orWhere('no_kk', 'like', "%{$keyword}%")
                  ->orWhere('alamat', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('rt') && $user->isKades()) {
            $query->where('rt', $request->rt);
        }

        if ($request->filled('status_dasar')) {
            $query->where('status_dasar', $request->status_dasar);
        } else {
            $query->where('status_dasar', 'hidup');
        }

        $penduduks = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view('penduduk.index', compact('penduduks', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('penduduk.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:penduduks,nik',
            'no_kk' => 'required|digits:16',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_pernikahan' => 'required|string',
            'golongan_darah' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'alamat' => 'required|string',
            'opt_in_persetujuan' => 'accepted',
        ], [
            'nik.required' => 'Nomor Induk Kependudukan (NIK) wajib diisi.',
            'nik.digits' => 'NIK harus berjumlah tepat 16 angka.',
            'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
            'no_kk.required' => 'Nomor Kartu Keluarga (KK) wajib diisi.',
            'no_kk.digits' => 'Nomor KK harus berjumlah 16 angka.',
            'nama.required' => 'Nama lengkap warga wajib diisi.',
            'opt_in_persetujuan.accepted' => 'Persetujuan warga (Opt-In PDP) wajib dicentang untuk mematuhi etika perlindungan data pribadi.',
        ]);

        if ($user->isRtRw()) {
            $validated['rt'] = $user->rt;
            $validated['rw'] = $user->rw;
        }

        $validated['opt_in_persetujuan'] = true;
        $validated['opt_in_at'] = now();
        $validated['created_by_user_id'] = $user->id;

        $penduduk = Penduduk::create($validated);

        AuditLog::record(
            'TAMBAH_PENDUDUK',
            'Penduduk',
            "Menambahkan data warga baru: {$penduduk->nama} (RT {$penduduk->rt}/RW {$penduduk->rw})",
            null,
            $penduduk->toArray()
        );

        return redirect()->route('penduduk.index')->with('success', "Data warga atas nama {$penduduk->nama} berhasil disimpan ke basis data.");
    }

    public function show(int $id)
    {
        $user = Auth::user();
        $penduduk = Penduduk::findOrFail($id);

        if (!$user->canAccessWilayah($penduduk->rt, $penduduk->rw)) {
            abort(403);
        }

        AuditLog::record(
            'LIHAT_DATA_SENSITIF',
            'Penduduk',
            "Melihat rincian identitas lengkap warga: {$penduduk->nama} (NIK: {$penduduk->masked_nik})"
        );

        return view('penduduk.show', compact('penduduk', 'user'));
    }

    public function edit(int $id)
    {
        $user = Auth::user();
        $penduduk = Penduduk::findOrFail($id);

        if (!$user->canAccessWilayah($penduduk->rt, $penduduk->rw)) {
            abort(403);
        }

        return view('penduduk.edit', compact('penduduk', 'user'));
    }

    public function update(Request $request, int $id)
    {
        $user = Auth::user();
        $penduduk = Penduduk::findOrFail($id);

        if (!$user->canAccessWilayah($penduduk->rt, $penduduk->rw)) {
            abort(403);
        }

        $validated = $request->validate([
            'no_kk' => 'required|digits:16',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pendidikan' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_pernikahan' => 'required|string',
            'golongan_darah' => 'required|string',
            'rt' => 'required|string|max:5',
            'rw' => 'required|string|max:5',
            'alamat' => 'required|string',
            'status_dasar' => 'required|in:hidup,meninggal,pindah',
        ]);

        $oldData = $penduduk->toArray();
        $validated['updated_by_user_id'] = $user->id;
        $penduduk->update($validated);

        AuditLog::record(
            'UBAH_PENDUDUK',
            'Penduduk',
            "Memperbarui biodata warga: {$penduduk->nama}",
            $oldData,
            $penduduk->toArray()
        );

        return redirect()->route('penduduk.show', $penduduk->id)->with('success', "Data warga {$penduduk->nama} berhasil diperbarui.");
    }

    public function destroy(int $id)
    {
        $user = Auth::user();
        $penduduk = Penduduk::findOrFail($id);

        if (!$user->canAccessWilayah($penduduk->rt, $penduduk->rw)) {
            abort(403);
        }

        $nama = $penduduk->nama;
        $old = $penduduk->toArray();
        $penduduk->delete();

        AuditLog::record(
            'HAPUS_PENDUDUK',
            'Penduduk',
            "Menghapus data kependudukan warga: {$nama}",
            $old,
            null
        );

        return redirect()->route('penduduk.index')->with('success', "Data warga {$nama} telah dihapus dari sistem.");
    }
}
