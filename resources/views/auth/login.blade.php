@extends('layouts.app')

@section('title', 'Masuk Akun Perangkat Desa - ' . config('desa.nama_desa'))
@section('page_title', 'Masuk Akun')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

    <!-- Header Halaman Masuk -->
    <div class="border-b border-stone-200 pb-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-stone-100 border border-stone-200 rounded text-xs text-slate-700 mb-2">
            <svg class="w-4 h-4 text-desa-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <span>Akses Khusus Perangkat & Kader Desa</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
            Masuk ke Sistem Informasi Desa
        </h1>
        <p class="text-sm sm:text-base text-slate-600 mt-1 max-prose-desa">
            Halaman ini digunakan oleh Kepala Desa, Ketua RT/RW, dan Kader Posyandu untuk mengelola administrasi kependudukan dan layanan warga.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- ========================================== -->
        <!-- KOLOM 1: FORMULIR LOGIN MANUAL -->
        <!-- ========================================== -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-7 rounded-lg border border-stone-200 space-y-5">
            <div class="border-b border-stone-100 pb-3">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-desa-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Formulir Masuk</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Gunakan akun surel resmi yang telah didaftarkan:</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-800 mb-1">
                        Alamat Surel (Email):
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="contoh: kades@kebonpedes.desa.id"
                           class="w-full px-3 py-2.5 text-base rounded border border-stone-300 focus:outline-none focus:border-desa-700 focus:ring-1 focus:ring-desa-700 bg-white @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs font-semibold text-rose-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-800 mb-1">
                        Kata Sandi (Password):
                    </label>
                    <input type="password" name="password" id="password" required
                           placeholder="Masukkan kata sandi Anda"
                           class="w-full px-3 py-2.5 text-base rounded border border-stone-300 focus:outline-none focus:border-desa-700 focus:ring-1 focus:ring-desa-700 bg-white">
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-desa-700 rounded border-stone-300 focus:ring-desa-700">
                        <span class="text-xs text-slate-700">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="btn-touch w-full px-4 py-3 bg-desa-700 hover:bg-desa-800 text-white font-bold text-base rounded transition text-center flex items-center justify-center gap-2 shadow-sm">
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

            <div class="pt-4 border-t border-stone-100 text-xs text-slate-500 space-y-2">
                <p>
                    <strong>Warga / Masyarakat Umum:</strong> Tidak perlu masuk akun untuk melapor KTP hilang, melacak surat, atau melihat produk UMKM.
                </p>
                <a href="{{ route('home') }}" class="text-desa-700 font-bold hover:underline inline-block">
                    &larr; Kembali ke Beranda Utama
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- KOLOM 2: AKUN DEMO RESMI (1-KLIK LOGIN) -->
        <!-- ========================================== -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-7 rounded-lg border border-stone-200 space-y-5">
            <div class="border-b border-stone-100 pb-3 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-desa-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Akses Cepat Mode Uji Coba (Demo)</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Pilih peran di bawah ini untuk mencoba sistem secara instan:
                    </p>
                </div>
                <span class="px-2.5 py-0.5 bg-stone-100 border border-stone-200 text-slate-700 font-bold text-xs rounded">
                    Tugas Kuliah
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($demoAccounts as $acc)
                    <div class="bg-stone-50 p-4 rounded-lg border border-stone-200 flex flex-col justify-between hover:border-stone-400 transition">
                        <div class="space-y-1.5 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold border border-stone-300 bg-white text-slate-800">
                                    {{ $acc['title'] }}
                                </span>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base leading-snug">{{ $acc['name'] }}</h3>
                            <p class="text-xs text-slate-500 font-mono">{{ $acc['email'] }}</p>
                            <p class="text-xs text-slate-600 leading-relaxed pt-1">{{ $acc['desc'] }}</p>
                        </div>

                        <a href="{{ route('login.demo', $acc['role_key']) }}" class="btn-touch w-full py-2 px-3 bg-desa-700 hover:bg-desa-800 text-white font-bold text-xs rounded text-center transition flex items-center justify-center gap-1.5">
                            <span>Masuk Sebagai {{ $acc['title'] }}</span> &rarr;
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Catatan Etika & Keamanan -->
            <div class="p-3.5 bg-stone-50 rounded border border-stone-200 text-xs text-slate-600 space-y-1">
                <p class="font-bold text-slate-800 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-desa-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Pembatasan Hak Akses (RBAC & UU PDP):</span>
                </p>
                <p class="text-[11px] leading-relaxed">
                    Setiap peran dibatasi hak aksesnya pada tingkat server. Ketua RT hanya mengelola warganya sendiri, Kader mengelola penimbangan balita, dan Kepala Desa menyetujui surat serta memeriksa log audit.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
