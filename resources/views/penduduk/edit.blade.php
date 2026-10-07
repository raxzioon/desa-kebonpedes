@extends('layouts.app')

@section('title', 'Ubah Data Warga: ' . $penduduk->nama . ' - ' . config('desa.nama_desa'))
@section('page_title', 'Ubah Biodata Warga')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('penduduk.show', $penduduk->id) }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Detail Warga
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Perbarui Biodata: {{ $penduduk->nama }}
        </h1>
        <p class="text-sm text-slate-600 font-mono">NIK: {{ $penduduk->masked_nik }}</p>
    </div>

    <form method="POST" action="{{ route('penduduk.update', $penduduk->id) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Nomor KK:</label>
                    <input type="text" name="no_kk" value="{{ old('no_kk', $penduduk->no_kk) }}" maxlength="16" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-mono">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Status Dasar Warga:</label>
                    <select name="status_dasar" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="hidup" {{ old('status_dasar', $penduduk->status_dasar) == 'hidup' ? 'selected' : '' }}>Hidup (Aktif)</option>
                        <option value="pindah" {{ old('status_dasar', $penduduk->status_dasar) == 'pindah' ? 'selected' : '' }}>Pindah Keluar</option>
                        <option value="meninggal" {{ old('status_dasar', $penduduk->status_dasar) == 'meninggal' ? 'selected' : '' }}>Meninggal Dunia</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Nama Lengkap:</label>
                    <input type="text" name="nama" value="{{ old('nama', $penduduk->nama) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 font-bold">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Jenis Kelamin:</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Golongan Darah:</label>
                    <select name="golongan_darah" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Tidak Tahu" {{ old('golongan_darah', $penduduk->golongan_darah) == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                        <option value="A" {{ old('golongan_darah', $penduduk->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah', $penduduk->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah', $penduduk->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah', $penduduk->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Tempat Lahir:</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Tanggal Lahir:</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir?->format('Y-m-d')) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Agama:</label>
                    <select name="agama" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Islam" {{ old('agama', $penduduk->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama', $penduduk->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama', $penduduk->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama', $penduduk->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama', $penduduk->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama', $penduduk->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Status Pernikahan:</label>
                    <select name="status_pernikahan" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Belum Menikah" {{ old('status_pernikahan', $penduduk->status_pernikahan) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('status_pernikahan', $penduduk->status_pernikahan) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Cerai Hidup" {{ old('status_pernikahan', $penduduk->status_pernikahan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_pernikahan', $penduduk->status_pernikahan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Pendidikan:</label>
                    <input type="text" name="pendidikan" value="{{ old('pendidikan', $penduduk->pendidikan) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Pekerjaan:</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">RT:</label>
                    <input type="text" name="rt" value="{{ old('rt', $penduduk->rt) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">RW:</label>
                    <input type="text" name="rw" value="{{ old('rw', $penduduk->rw) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-800 text-base mb-1.5">Alamat Lengkap:</label>
                    <textarea name="alamat" rows="2" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">{{ old('alamat', $penduduk->alamat) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('penduduk.show', $penduduk->id) }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl">
                💾 Simpan Perubahan Data
            </button>
        </div>
    </form>
</div>
@endsection
