<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panduan;

class PanduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Panduan::where('is_aktif', true);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $panduans = $query->orderBy('urutan')->get();
        $kategoris = Panduan::select('kategori')->distinct()->pluck('kategori');

        return view('panduan.index', compact('panduans', 'kategoris'));
    }

    public function show(string $slug)
    {
        $panduan = Panduan::where('slug', $slug)->firstOrFail();
        $panduanLain = Panduan::where('slug', '!=', $slug)->orderBy('urutan')->take(4)->get();
        return view('panduan.show', compact('panduan', 'panduanLain'));
    }

    public function latihan()
    {
        return view('panduan.latihan');
    }
}
