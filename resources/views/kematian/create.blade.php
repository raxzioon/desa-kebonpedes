@extends('layouts.app')

@section('title', 'Catat Warga Meninggal - ' . config('desa.nama_desa'))
@section('page_title', 'Catat Kematian Warga')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('kematian.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Catatan Kematian
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Pencatatan Warga Meninggal Dunia
        </h1>
        <p class="text-sm text-slate-600">
            Pilih warga dan isi keterangan kematian untuk keperluan verifikasi Kepala Desa.
        </p>
    </div>

    <form method="POST" action="{{ route('kematian.store') }}" class="space-y-8">
        @csrf

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>1️⃣</span> Pilih Data Warga yang Wafat
            </h2>

            <div>
                <label for="penduduk_id" class="block font-bold text-slate-800 text-base mb-1.5">
                    Nama Warga: <span class="text-rose-500">*</span>
                </label>
                <select name="penduduk_id" id="penduduk_id" required class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold text-slate-900">
                    <option value="">-- Pilih Warga dari Database --</option>
                    @foreach($penduduks as $p)
                        <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama }} (NIK: {{ $p->masked_nik }} &bull; RT {{ $p->rt }}/RW {{ $p->rw }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>2️⃣</span> Rincian Waktu & Sebab Kematian
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_kematian" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tanggal Wafat: <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kematian" id="tanggal_kematian" value="{{ old('tanggal_kematian', date('Y-m-d')) }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="waktu_kematian" class="block font-bold text-slate-800 text-base mb-1.5">
                        Waktu / Jam Kematian:
                    </label>
                    <input type="text" name="waktu_kematian" id="waktu_kematian" value="{{ old('waktu_kematian', '05.30 WIB') }}" placeholder="Contoh: 05.30 WIB" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="tempat_kematian" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tempat Meninggal: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="tempat_kematian" id="tempat_kematian" value="{{ old('tempat_kematian', 'Rumah Duka') }}" required placeholder="Contoh: Rumah Duka / RSUD Sekarwangi" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="sebab_kematian" class="block font-bold text-slate-800 text-base mb-1.5">
                        Sebab Meninggal: <span class="text-rose-500">*</span>
                    </label>
                    <select name="sebab_kematian" id="sebab_kematian" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white font-semibold">
                        <option value="Sakit Usia Lanjut / Menua">Sakit Usia Lanjut / Menua</option>
                        <option value="Sakit Biasa">Sakit Biasa</option>
                        <option value="Penyakit Jantung / Stroke">Penyakit Jantung / Stroke</option>
                        <option value="Kecelakaan Lalu Lintas">Kecelakaan Lalu Lintas</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md space-y-6">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>3️⃣</span> Data Pelapor / Ahli Waris
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="nama_pelapor" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nama Lengkap Pelapor: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_pelapor" id="nama_pelapor" value="{{ old('nama_pelapor') }}" required placeholder="Contoh: Bpk. Ahmad" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="hubungan_pelapor" class="block font-bold text-slate-800 text-base mb-1.5">
                        Hubungan dengan Almarhum: <span class="text-rose-500">*</span>
                    </label>
                    <select name="hubungan_pelapor" id="hubungan_pelapor" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Anak Kandung">Anak Kandung</option>
                        <option value="Suami / Istri">Suami / Istri</option>
                        <option value="Orang Tua">Orang Tua</option>
                        <option value="Saudara Kandung">Saudara Kandung</option>
                        <option value="Ketua RT / Tetangga Dekat">Ketua RT / Tetangga Dekat</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('kematian.index') }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-rose-700 hover:bg-rose-800 text-white font-black text-lg rounded-2xl shadow-xl">
                💾 Simpan Catatan Kematian
            </button>
        </div>
    </form>
</div>
@endsection
