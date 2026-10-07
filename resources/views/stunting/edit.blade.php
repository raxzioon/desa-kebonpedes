@extends('layouts.app')

@section('title', 'Ubah Pemeriksaan Balita: ' . $stunting->nama_anak . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Ubah Pemeriksaan Balita')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('stunting.show', $stunting->id) }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Rincian Balita
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Perbarui Hasil Ukur: {{ $stunting->nama_anak }}
        </h1>
    </div>

    <form method="POST" action="{{ route('stunting.update', $stunting->id) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Nama Balita:</label>
                    <input type="text" name="nama_anak" value="{{ old('nama_anak', $stunting->nama_anak) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">NIK Anak:</label>
                    <input type="text" name="nik_anak" value="{{ old('nik_anak', $stunting->nik_anak) }}" maxlength="16" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $stunting->tanggal_lahir?->format('Y-m-d')) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Jenis Kelamin:</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="L" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $stunting->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Nama Ibu:</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $stunting->nama_ibu) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Nama Ayah:</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $stunting->nama_ayah) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">RT:</label>
                    <input type="text" name="rt" value="{{ old('rt', $stunting->rt) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">RW:</label>
                    <input type="text" name="rw" value="{{ old('rw', $stunting->rw) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Berat Badan (kg):</label>
                    <input type="number" step="0.01" name="berat_badan" value="{{ old('berat_badan', $stunting->berat_badan) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold text-emerald-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Tinggi Badan (cm):</label>
                    <input type="number" step="0.01" name="tinggi_badan" value="{{ old('tinggi_badan', $stunting->tinggi_badan) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold text-emerald-800">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Lingkar Kepala (cm):</label>
                    <input type="number" step="0.01" name="lingkar_kepala" value="{{ old('lingkar_kepala', $stunting->lingkar_kepala) }}" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Tanggal Cek:</label>
                    <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $stunting->tanggal_pemeriksaan?->format('Y-m-d')) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Status Gizi:</label>
                    <select name="status_gizi" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold">
                        <option value="Gizi Baik (Normal)" {{ old('status_gizi', $stunting->status_gizi) == 'Gizi Baik (Normal)' ? 'selected' : '' }}>Gizi Baik (Normal)</option>
                        <option value="Gizi Kurang" {{ old('status_gizi', $stunting->status_gizi) == 'Gizi Kurang' ? 'selected' : '' }}>Gizi Kurang</option>
                        <option value="Gizi Buruk" {{ old('status_gizi', $stunting->status_gizi) == 'Gizi Buruk' ? 'selected' : '' }}>Gizi Buruk</option>
                        <option value="Risiko Gizi Lebih" {{ old('status_gizi', $stunting->status_gizi) == 'Risiko Gizi Lebih' ? 'selected' : '' }}>Risiko Gizi Lebih</option>
                        <option value="Gizi Lebih" {{ old('status_gizi', $stunting->status_gizi) == 'Gizi Lebih' ? 'selected' : '' }}>Gizi Lebih</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Status Stunting:</label>
                    <select name="status_stunting" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold text-emerald-900">
                        <option value="Normal" {{ old('status_stunting', $stunting->status_stunting) == 'Normal' ? 'selected' : '' }}>Normal (Tumbuh Sehat)</option>
                        <option value="Pendek (Stunted)" {{ old('status_stunting', $stunting->status_stunting) == 'Pendek (Stunted)' ? 'selected' : '' }}>Pendek (Stunted)</option>
                        <option value="Sangat Pendek (Severely Stunted)" {{ old('status_stunting', $stunting->status_stunting) == 'Sangat Pendek (Severely Stunted)' ? 'selected' : '' }}>Sangat Pendek (Severe)</option>
                        <option value="Tinggi" {{ old('status_stunting', $stunting->status_stunting) == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Posyandu:</label>
                    <input type="text" name="posyandu_nama" value="{{ old('posyandu_nama', $stunting->posyandu_nama) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Intervensi & PMT:</label>
                    <input type="text" name="intervensi_diberikan" value="{{ old('intervensi_diberikan', $stunting->intervensi_diberikan) }}" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Catatan Kader:</label>
                    <textarea name="catatan_kader" rows="2" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">{{ old('catatan_kader', $stunting->catatan_kader) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('stunting.show', $stunting->id) }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
