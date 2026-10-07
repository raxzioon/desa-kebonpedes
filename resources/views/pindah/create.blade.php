@extends('layouts.app')

@section('title', 'Ajukan Surat Pindah Warga - ' . config('desa.nama_desa'))
@section('page_title', 'Ajukan Surat Pindah')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('pindah.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Riwayat Pindah
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Pengajuan Surat Keterangan Pindah Keluar
        </h1>
        <p class="text-sm text-slate-600">
            Pilih warga yang hendak mengajukan kepindahan domisili ke luar desa / wilayah lain.
        </p>
    </div>

    <form method="POST" action="{{ route('pindah.store') }}" class="space-y-8">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>1️⃣</span> Pilih Warga yang Pindah
            </h2>

            <div>
                <label for="penduduk_id" class="block font-bold text-slate-800 text-base mb-1.5">
                    Nama Warga Terdaftar: <span class="text-rose-500">*</span>
                </label>
                <select name="penduduk_id" id="penduduk_id" required class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold text-slate-900">
                    <option value="">-- Pilih Warga dari Database --</option>
                    @foreach($penduduks as $p)
                        <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }} (NIK: {{ $p->masked_nik }} &bull; RT {{ $p->rt }}/RW {{ $p->rw }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-1">Hanya menampilkan warga berstatus hidup di wilayah wewenang Anda.</p>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>2️⃣</span> Alamat & Wilayah Tujuan
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label for="alamat_tujuan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Alamat Lengkap Tujuan: <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alamat_tujuan" id="alamat_tujuan" rows="2" required placeholder="Contoh: Jl. Diponegoro No. 12, RT 02/RW 04" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">{{ old('alamat_tujuan') }}</textarea>
                </div>

                <div>
                    <label for="desa_kelurahan_tujuan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Desa / Kelurahan Tujuan: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="desa_kelurahan_tujuan" id="desa_kelurahan_tujuan" value="{{ old('desa_kelurahan_tujuan') }}" required placeholder="Contoh: Cikole" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="kecamatan_tujuan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Kecamatan Tujuan: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="kecamatan_tujuan" id="kecamatan_tujuan" value="{{ old('kecamatan_tujuan') }}" required placeholder="Contoh: Cikole" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="kabupaten_kota_tujuan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Kabupaten / Kota Tujuan: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="kabupaten_kota_tujuan" id="kabupaten_kota_tujuan" value="{{ old('kabupaten_kota_tujuan', 'Kota Sukabumi') }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="provinsi_tujuan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Provinsi Tujuan: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="provinsi_tujuan" id="provinsi_tujuan" value="{{ old('provinsi_tujuan', 'Jawa Barat') }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="alasan_pindah" class="block font-bold text-slate-800 text-base mb-1.5">
                        Alasan Kepindahan: <span class="text-rose-500">*</span>
                    </label>
                    <select name="alasan_pindah" id="alasan_pindah" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Pekerjaan">Pekerjaan</option>
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Pernikahan">Pernikahan</option>
                        <option value="Mengikuti Keluarga">Mengikuti Keluarga</option>
                        <option value="Perumahan / Membeli Rumah">Perumahan / Membeli Rumah</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_pindah" class="block font-bold text-slate-800 text-base mb-1.5">
                        Rencana Tanggal Pindah: <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_pindah" id="tanggal_pindah" value="{{ old('tanggal_pindah', date('Y-m-d')) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="jumlah_keluarga_pindah" class="block font-bold text-slate-800 text-base mb-1.5">
                        Jumlah Anggota Keluarga Ikut Pindah: <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" min="1" name="jumlah_keluarga_pindah" id="jumlah_keluarga_pindah" value="{{ old('jumlah_keluarga_pindah', 1) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('pindah.index') }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl">
                🚀 Ajukan Surat Pengantar Pindah
            </button>
        </div>
    </form>
</div>
@endsection
