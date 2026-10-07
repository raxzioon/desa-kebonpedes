@extends('layouts.app')

@section('title', 'Tambah Warga Baru - ' . config('desa.nama_desa'))
@section('page_title', 'Tambah Warga')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('penduduk.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Daftar Warga
        </a>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Formulir Pendaftaran Warga Baru
        </h1>
        <p class="text-sm text-slate-600">
            Isi data warga dengan cermat. Pastikan warga telah memberikan persetujuan pencatatan data.
        </p>
    </div>

    <form method="POST" action="{{ route('penduduk.store') }}" class="space-y-8">
        @csrf

        <!-- BAGIAN 1: IDENTITAS POKOK -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black">1</span>
                <span>Identitas Pokok Warga</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label for="nik" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nomor Induk Kependudukan (NIK): <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" required placeholder="Contoh: 3202141501800001" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 font-mono @error('nik') border-rose-500 @enderror">
                    <p class="text-xs text-slate-500 mt-1">Harus tepat 16 digit angka sesuai KTP/KK.</p>
                    @error('nik')
                        <p class="text-xs font-bold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No KK -->
                <div>
                    <label for="no_kk" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nomor Kartu Keluarga (No. KK): <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="no_kk" id="no_kk" value="{{ old('no_kk') }}" maxlength="16" required placeholder="Contoh: 3202140101800001" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 font-mono @error('no_kk') border-rose-500 @enderror">
                    <p class="text-xs text-slate-500 mt-1">16 digit nomor KK keluarga.</p>
                </div>

                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label for="nama" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nama Lengkap (Sesuai KTP): <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Ahmad Sudrajat" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 font-bold @error('nama') border-rose-500 @enderror">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block font-bold text-slate-800 text-base mb-1.5">
                        Jenis Kelamin: <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex-1 btn-touch px-4 py-3 rounded-2xl border-2 border-slate-300 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50 cursor-pointer text-center font-bold">
                            <input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', 'L') === 'L' ? 'checked' : '' }} class="mr-2 text-emerald-600"> Laki-laki
                        </label>
                        <label class="flex-1 btn-touch px-4 py-3 rounded-2xl border-2 border-slate-300 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50 cursor-pointer text-center font-bold">
                            <input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin') === 'P' ? 'checked' : '' }} class="mr-2 text-emerald-600"> Perempuan
                        </label>
                    </div>
                </div>

                <!-- Golongan Darah -->
                <div>
                    <label for="golongan_darah" class="block font-bold text-slate-800 text-base mb-1.5">
                        Golongan Darah:
                    </label>
                    <select name="golongan_darah" id="golongan_darah" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600 bg-white">
                        <option value="Tidak Tahu" {{ old('golongan_darah') == 'Tidak Tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tempat Lahir: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', 'Sukabumi') }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tanggal Lahir: <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600">
                </div>
            </div>
        </div>

        <!-- BAGIAN 2: STATUS & SOSIAL -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-sm font-black">2</span>
                <span>Sosial & Pendidikan</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Agama -->
                <div>
                    <label for="agama" class="block font-bold text-slate-800 text-base mb-1.5">Agama:</label>
                    <select name="agama" id="agama" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>

                <!-- Status Pernikahan -->
                <div>
                    <label for="status_pernikahan" class="block font-bold text-slate-800 text-base mb-1.5">Status Pernikahan:</label>
                    <select name="status_pernikahan" id="status_pernikahan" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Belum Menikah" {{ old('status_pernikahan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('status_pernikahan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Cerai Hidup" {{ old('status_pernikahan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_pernikahan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                <!-- Pendidikan Terakhir -->
                <div>
                    <label for="pendidikan" class="block font-bold text-slate-800 text-base mb-1.5">Pendidikan Terakhir:</label>
                    <select name="pendidikan" id="pendidikan" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="SD/Sederajat" {{ old('pendidikan') == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                        <option value="SMP/Sederajat" {{ old('pendidikan') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                        <option value="SMA/Sederajat" {{ old('pendidikan', 'SMA/Sederajat') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA / Sederajat / SMK</option>
                        <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>Diploma (D1/D2/D3)</option>
                        <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                        <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                        <option value="Tidak/Belum Sekolah" {{ old('pendidikan') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label for="pekerjaan" class="block font-bold text-slate-800 text-base mb-1.5">Pekerjaan Utama:</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', 'Wiraswasta') }}" required placeholder="Contoh: Petani / Pedagang / Buruh" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600">
                </div>
            </div>
        </div>

        <!-- BAGIAN 3: ALAMAT & WILAYAH RT/RW -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-2 pb-3 border-b border-slate-100">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-sm font-black">3</span>
                <span>Alamat Tempat Tinggal (Domisili)</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- RT -->
                <div>
                    <label for="rt" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nomor RT: <span class="text-rose-500">*</span>
                    </label>
                    @if($user->isRtRw())
                        <input type="text" name="rt" id="rt" value="{{ $user->rt }}" readonly class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-200 bg-slate-100 font-bold text-slate-700">
                        <p class="text-xs text-slate-500 mt-1">Terkunci otomatis pada wilayah RT Anda.</p>
                    @else
                        <select name="rt" id="rt" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                            <option value="01" {{ old('rt') == '01' ? 'selected' : '' }}>RT 01</option>
                            <option value="02" {{ old('rt') == '02' ? 'selected' : '' }}>RT 02</option>
                            <option value="03" {{ old('rt') == '03' ? 'selected' : '' }}>RT 03</option>
                        </select>
                    @endif
                </div>

                <!-- RW -->
                <div>
                    <label for="rw" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nomor RW: <span class="text-rose-500">*</span>
                    </label>
                    @if($user->isRtRw())
                        <input type="text" name="rw" id="rw" value="{{ $user->rw }}" readonly class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-200 bg-slate-100 font-bold text-slate-700">
                    @else
                        <select name="rw" id="rw" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 bg-white">
                            <option value="01" {{ old('rw') == '01' ? 'selected' : '' }}>RW 01</option>
                            <option value="02" {{ old('rw') == '02' ? 'selected' : '' }}>RW 02</option>
                            <option value="03" {{ old('rw') == '03' ? 'selected' : '' }}>RW 03</option>
                        </select>
                    @endif
                </div>

                <!-- Alamat Lengkap -->
                <div class="sm:col-span-2">
                    <label for="alamat" class="block font-bold text-slate-800 text-base mb-1.5">
                        Alamat Lengkap / Nama Kampung / Gang: <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2" required placeholder="Contoh: Kp. Kebonpedes Girang No. 15" class="w-full px-4 py-3 text-base rounded-2xl border-2 border-slate-300 focus:border-emerald-600">{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <!-- BAGIAN 4: PERSETUJUAN EKSPLISIT (OPT-IN PDP & ETIKA PROFESI) -->
        <div class="p-6 sm:p-8 bg-emerald-50 rounded-3xl border-2 border-emerald-400 shadow-md">
            <h3 class="text-lg font-black text-emerald-950 mb-3 flex items-center gap-2">
                <span>🛡️</span> Persetujuan Perlindungan Data Pribadi (Opt-In Consent)
            </h3>
            <p class="text-sm text-emerald-900 leading-relaxed mb-4">
                Sesuai Undang-Undang Perlindungan Data Pribadi (UU No. 27/2022) dan Kode Etik Profesi Sistem Informasi, data warga hanya digunakan untuk keperluan pelayanan administrasi desa yang sah dan tidak disebarluaskan kepada pihak ketiga tanpa izin.
            </p>

            <label class="flex items-start gap-3 cursor-pointer p-4 bg-white rounded-2xl border-2 border-emerald-300">
                <input type="checkbox" name="opt_in_persetujuan" value="1" {{ old('opt_in_persetujuan') ? 'checked' : '' }} required class="w-6 h-6 text-emerald-600 rounded-lg border-2 border-slate-300 focus:ring-emerald-500 shrink-0 mt-0.5">
                <span class="text-sm font-bold text-slate-900 leading-snug">
                    Saya menyatakan bahwa data di atas telah diverifikasi dan warga bersangkutan telah memberikan izin secara sadar untuk dicatatkan ke dalam database kependudukan {{ config('desa.nama_desa') }}.
                </span>
            </label>
            @error('opt_in_persetujuan')
                <p class="text-xs font-bold text-rose-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row gap-4 justify-end pt-4">
            <a href="{{ route('penduduk.index') }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-base rounded-2xl border border-slate-300 text-center">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl transition transform active:scale-95">
                💾 Simpan Data Warga
            </button>
        </div>
    </form>
</div>
@endsection
