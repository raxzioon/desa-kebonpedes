@extends('layouts.app')

@section('title', 'Formulir Lapor KTP Hilang - ' . config('desa.nama_desa'))
@section('page_title', 'Formulir KTP Hilang')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 text-center sm:text-left">
        <a href="{{ route('ktp-hilang.index') }}" class="text-sm font-bold text-slate-600 hover:text-emerald-700 inline-flex items-center gap-1">
            &larr; Kembali ke Layanan KTP
        </a>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight mt-2">
            Formulir Permohonan Surat Keterangan KTP Hilang
        </h1>
        <p class="text-base text-slate-600 mt-1">
            Silakan isi data diri dan keterangan kehilangan dengan benar. Surat resmi akan diproses oleh Ketua RT dan Kepala Desa.
        </p>
    </div>

    <!-- Kotak Bantuan Khusus Pengguna Lanjut Usia -->
    <div class="mb-8 p-5 bg-amber-50 rounded-3xl border-2 border-amber-300 flex items-start gap-4 shadow-sm">
        <span class="text-3xl">💡</span>
        <div class="text-sm text-amber-950 leading-relaxed">
            <strong>Bantuan Pengisian Formulir:</strong> Jika Bapak/Ibu merasa kesulitan atau huruf kurang jelas, silakan tekan tombol <strong>A++ Besar</strong> di atas atau minta bantuan Ketua RT setempat.
        </div>
    </div>

    <form method="POST" action="{{ route('ktp-hilang.store') }}" class="space-y-8">
        @csrf

        <!-- 1. DATA IDENTITAS PEMOHON -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black">1</span>
                <span>Data Identitas Pemohon (Sesuai KK / KTP Lama)</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label for="nik_pemohon" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nomor NIK Pemohon: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nik_pemohon" id="nik_pemohon" value="{{ old('nik_pemohon') }}" maxlength="16" required placeholder="Contoh: 3202141501800001" class="w-full px-4 py-3.5 text-lg rounded-2xl border-2 border-slate-300 font-mono @error('nik_pemohon') border-rose-500 @enderror">
                    <p class="text-xs text-slate-500 mt-1">16 digit nomor induk pada Kartu Keluarga.</p>
                    @error('nik_pemohon')
                        <p class="text-xs font-bold text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_pemohon" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nama Lengkap: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_pemohon" id="nama_pemohon" value="{{ old('nama_pemohon') }}" required placeholder="Contoh: Ahmad Sudrajat" class="w-full px-4 py-3.5 text-lg rounded-2xl border-2 border-slate-300 font-bold focus:border-emerald-600">
                </div>

                <!-- No WhatsApp -->
                <div>
                    <label for="no_hp" class="block font-bold text-slate-800 text-base mb-1.5">
                        Nomor HP / WhatsApp Aktif: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300 font-mono">
                    <p class="text-xs text-slate-500 mt-1">Digunakan untuk pemberitahuan saat surat selesai.</p>
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

                <!-- Tempat Lahir -->
                <div>
                    <label for="tempat_lahir" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tempat Lahir: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', 'Sukabumi') }}" required class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tanggal Lahir: <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <!-- Agama -->
                <div>
                    <label for="agama" class="block font-bold text-slate-800 text-base mb-1.5">Agama:</label>
                    <select name="agama" id="agama" class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300 bg-white">
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>

                <!-- Pekerjaan -->
                <div>
                    <label for="pekerjaan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Pekerjaan: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', 'Wiraswasta') }}" required class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <!-- RT & RW -->
                <div>
                    <label for="rt" class="block font-bold text-slate-800 text-base mb-1.5">RT Domisili:</label>
                    <select name="rt" id="rt" class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold">
                        <option value="01">RT 01</option>
                        <option value="02">RT 02</option>
                        <option value="03">RT 03</option>
                    </select>
                </div>

                <div>
                    <label for="rw" class="block font-bold text-slate-800 text-base mb-1.5">RW Domisili:</label>
                    <select name="rw" id="rw" class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300 bg-white font-bold">
                        <option value="01">RW 01</option>
                        <option value="02">RW 02</option>
                        <option value="03">RW 03</option>
                    </select>
                </div>

                <!-- Alamat Lengkap -->
                <div class="sm:col-span-2">
                    <label for="alamat" class="block font-bold text-slate-800 text-base mb-1.5">
                        Alamat Tempat Tinggal di Desa: <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2" required placeholder="Contoh: Kp. Kebonpedes Girang No. 12" class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 2. KRONOLOGI KEHILANGAN -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border-2 border-slate-200 shadow-md">
            <h2 class="text-xl font-black text-slate-900 pb-3 border-b border-slate-100 mb-6 flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-sm font-black">2</span>
                <span>Keterangan Waktu & Lokasi Kehilangan</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="lokasi_kehilangan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Perkiraan Tempat / Lokasi Hilang: <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="lokasi_kehilangan" id="lokasi_kehilangan" value="{{ old('lokasi_kehilangan') }}" required placeholder="Contoh: Sekitar Pasar Kebonpedes / Angkutan Umum" class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div>
                    <label for="tanggal_kehilangan" class="block font-bold text-slate-800 text-base mb-1.5">
                        Tanggal Kejadian Hilang: <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kehilangan" id="tanggal_kehilangan" value="{{ old('tanggal_kehilangan', date('Y-m-d')) }}" required class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">
                </div>

                <div class="sm:col-span-2">
                    <label for="kronologi" class="block font-bold text-slate-800 text-base mb-1.5">
                        Kronologi / Cerita Singkat Kejadian: <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="kronologi" id="kronologi" rows="3" required placeholder="Contoh: Dompet terjatuh saat berkendara motor dari pasar menuju rumah, berisi KTP dan surat penting lainnya..." class="w-full px-4 py-3.5 text-base rounded-2xl border-2 border-slate-300">{{ old('kronologi') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 3. PERNYATAAN & PERSETUJUAN ETIKA EKSPLISIT (PDP) -->
        <div class="p-6 sm:p-8 bg-emerald-50 rounded-3xl border-2 border-emerald-400 shadow-md">
            <h3 class="text-lg font-black text-emerald-950 mb-3 flex items-center gap-2">
                <span>🛡️</span> Pernyataan Keaslian Data & Perlindungan Privasi
            </h3>
            <p class="text-sm text-emerald-900 leading-relaxed mb-4">
                Saya menyatakan bahwa keterangan kehilangan yang saya berikan adalah benar adanya dan siap bertanggung jawab secara hukum apabila memberikan keterangan palsu.
            </p>

            <label class="flex items-start gap-3 cursor-pointer p-4 bg-white rounded-2xl border-2 border-emerald-300">
                <input type="checkbox" name="opt_in_persetujuan" value="1" {{ old('opt_in_persetujuan') ? 'checked' : '' }} required class="w-6 h-6 text-emerald-600 rounded-lg border-2 border-slate-300 focus:ring-emerald-500 shrink-0 mt-0.5">
                <span class="text-sm font-bold text-slate-900 leading-snug">
                    Saya menyetujui pemrosesan data identitas saya oleh Pemerintah {{ config('desa.nama_desa') }} untuk penerbitan Surat Keterangan Kehilangan KTP.
                </span>
            </label>
            @error('opt_in_persetujuan')
                <p class="text-xs font-bold text-rose-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <a href="{{ route('ktp-hilang.index') }}" class="btn-touch px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-base rounded-2xl border border-slate-300 text-center">
                Batal
            </a>
            <button type="submit" class="btn-touch px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-xl transition transform active:scale-95">
                🚀 Kirim Pengajuan Surat KTP
            </button>
        </div>
    </form>
</div>
@endsection
