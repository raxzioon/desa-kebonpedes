@extends('layouts.app')

@section('title', 'Masuk Akun Perangkat Desa - ' . config('desa.nama_desa'))
@section('page_title', 'Masuk Akun')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="text-center max-w-3xl mx-auto mb-10">
        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-900 font-bold text-sm rounded-full border border-emerald-300 inline-block mb-3">
            🔐 Area Khusus Perangkat & Kader Desa
        </span>
        <h1 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight mb-4">
            Masuk ke Sistem Informasi Desa
        </h1>
        <p class="text-lg md:text-xl text-slate-600 leading-relaxed">
            Halaman ini dikhususkan bagi Kepala Desa, Ketua RT/RW, dan Kader Posyandu untuk mengelola data warga dan pelayanan administrasi.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- ========================================== -->
        <!-- KOLOM 1: FORMULIR LOGIN MANUAL -->
        <!-- ========================================== -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl shadow-xl border-2 border-slate-200">
            <h2 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-2">
                <span>📝</span> Formulir Masuk
            </h2>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block font-bold text-slate-800 text-base mb-2">
                        Alamat Surel (Email) Akun:
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="contoh: kades@kebonpedes.desa.id"
                           class="w-full px-5 py-4 text-base md:text-lg rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 outline-none transition @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="mt-2 text-sm font-semibold text-rose-600 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block font-bold text-slate-800 text-base mb-2">
                        Kata Sandi (Password):
                    </label>
                    <input type="password" name="password" id="password" required
                           placeholder="Masukkan kata sandi Anda"
                           class="w-full px-5 py-4 text-base md:text-lg rounded-2xl border-2 border-slate-300 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100 outline-none transition">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-5 h-5 text-emerald-600 rounded-lg border-2 border-slate-300 focus:ring-emerald-500">
                        <span class="text-base text-slate-700 font-medium">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-touch py-4 px-6 bg-emerald-700 hover:bg-emerald-800 text-white font-black text-lg rounded-2xl shadow-lg hover:shadow-xl transition transform active:scale-95">
                    🚀 Masuk Sekarang
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 text-center">
                <p class="text-sm text-slate-500 leading-relaxed">
                    Masyarakat umum tidak perlu masuk akun untuk melihat pengumuman, etalase UMKM, atau melacak status surat KTP hilang.
                </p>
                <a href="{{ route('home') }}" class="inline-block mt-3 text-emerald-700 font-bold hover:underline">
                    &larr; Kembali ke Beranda Publik
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- KOLOM 2: AKUN DEMO RESMI (1-KLIK LOGIN) -->
        <!-- ========================================== -->
        <div class="lg:col-span-7 bg-gradient-to-br from-emerald-50 via-teal-50 to-emerald-100 p-6 sm:p-8 rounded-3xl border-2 border-emerald-300 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-black text-emerald-950 flex items-center gap-2">
                    <span>⚡</span> 1-Klik Masuk Mode Demo
                </h2>
                <span class="px-3 py-1 bg-amber-400 text-slate-900 font-black text-xs rounded-full uppercase tracking-wider">
                    Uji Coba Cepat
                </span>
            </div>
            
            <p class="text-base text-emerald-900 mb-6 leading-relaxed">
                Khusus presentasi tugas besar dan demonstrasi narasumber perangkat desa, klik salah satu tombol di bawah untuk langsung mencoba sistem sesuai peran:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($demoAccounts as $acc)
                    <div class="bg-white p-5 rounded-2xl border-2 border-emerald-200 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-3xl">{{ $acc['icon'] }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black border {{ $acc['badge'] }}">
                                    {{ $acc['title'] }}
                                </span>
                            </div>
                            <h3 class="font-black text-slate-900 text-lg mb-1">{{ $acc['name'] }}</h3>
                            <p class="text-xs text-slate-500 font-mono mb-2">{{ $acc['email'] }}</p>
                            <p class="text-xs text-slate-600 leading-relaxed mb-4">{{ $acc['desc'] }}</p>
                        </div>

                        <a href="{{ route('login.demo', $acc['role_key']) }}" class="w-full btn-touch py-2.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl text-center shadow transition flex items-center justify-center gap-2">
                            <span>Masuk Sebagai {{ $acc['title'] }}</span> &rarr;
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Catatan Keamanan & Etika -->
            <div class="mt-6 p-4 bg-white/80 rounded-2xl border border-emerald-200 text-xs text-slate-600 leading-relaxed flex items-start gap-3">
                <span class="text-xl">🔒</span>
                <div>
                    <strong class="text-slate-800">Prinsip Keamanan & Etika Profesi:</strong>
                    Sistem membatasi hak akses secara ketat di sisi server (RBAC). Ketua RT hanya dapat mengelola data warganya sendiri, Kader hanya dapat mengelola data kesehatan balita, dan Kepala Desa memiliki wewenang persetujuan akhir serta audit trail.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
