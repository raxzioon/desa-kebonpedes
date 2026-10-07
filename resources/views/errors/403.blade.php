@extends('layouts.app')

@section('title', 'Akses Dibatasi (403) - ' . config('desa.nama_desa'))

@section('content')
<div class="max-w-3xl mx-auto my-12 bg-white rounded-3xl shadow-xl border-2 border-rose-200 p-8 md:p-12 text-center">
    <div class="w-24 h-24 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl shadow-inner">
        🛡️
    </div>

    <span class="inline-block px-4 py-1.5 bg-rose-100 text-rose-800 font-bold text-sm rounded-full mb-3 border border-rose-300">
        Kode Keamanan: 403 - Akses Ditolak
    </span>

    <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-4 tracking-tight">
        Halaman Dibatasi Berdasarkan Hak Akses
    </h1>

    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
        Mohon maaf, peran Anda saat ini (<strong>{{ auth()->user()->role_label ?? 'Tamu Publik' }}</strong>) tidak memiliki wewenang untuk membuka atau mengubah data pada halaman ini.
    </p>

    <!-- Penjelasan Prinsip Etika & Keamanan -->
    <div class="bg-amber-50 border-l-4 border-amber-500 p-5 rounded-2xl text-left mb-8">
        <h4 class="font-bold text-amber-900 text-base flex items-center gap-2 mb-1">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Catatan Etika Profesi & Perlindungan Data Pribadi:
        </h4>
        <p class="text-sm text-amber-800 leading-relaxed">
            Sistem Informasi Desa Kebonpedes menerapkan prinsip <em>Role-Based Access Control</em> (RBAC) dan <em>Need-to-Know Basis</em> demi menjaga kerahasiaan identitas dan data sensitif warga masyarakat desa. Upaya akses ini telah dicatat dalam riwayat audit sistem.
        </p>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        @auth
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transition min-h-[48px]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Kembali ke Dashboard Saya
            </a>
        @else
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl transition min-h-[48px]">
                Masuk Akun Perangkat
            </a>
        @endauth

        <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-lg rounded-2xl border border-slate-300 transition min-h-[48px]">
            Kembali ke Beranda Umum
        </a>
    </div>
</div>
@endsection
