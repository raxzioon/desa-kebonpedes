<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = Umkm::where('is_aktif', true);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk', 'like', "%{$keyword}%")
                  ->orWhere('nama_pemilik', 'like', "%{$keyword}%")
                  ->orWhere('nama_usaha', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $kategoris = Umkm::select('kategori')->distinct()->pluck('kategori');
        $umkms = $query->latest()->paginate(8)->withQueryString();

        return view('umkm.index', compact('umkms', 'kategoris'));
    }

    public function show(int $id)
    {
        $umkm = Umkm::findOrFail($id);
        $produkLain = Umkm::where('is_aktif', true)->where('id', '!=', $id)->take(3)->get();
        return view('umkm.show', compact('umkm', 'produkLain'));
    }
}
