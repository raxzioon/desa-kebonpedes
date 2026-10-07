<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('desa.nama_desa') . ' - Sistem Informasi Desa')</title>

    <!-- Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        desa: {
                            50: '#f4f7f4',
                            100: '#e5eee5',
                            200: '#cbddcb',
                            600: '#2d6a4f',
                            700: '#1b4332',
                            800: '#143426',
                            900: '#0d2219',
                        },
                        krem: {
                            50: '#faf9f6',
                            100: '#f3f0e8',
                            200: '#e6e1d5',
                        }
                    },
                    borderRadius: {
                        DEFAULT: '6px',
                        'sm': '4px',
                        'md': '6px',
                        'lg': '8px',
                        'xl': '8px',
                        '2xl': '8px',
                        '3xl': '8px',
                        'full': '9999px',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Ukuran dasar teks 18px */
        html {
            font-size: 18px;
        }
        html.text-size-medium {
            font-size: 21px !important;
        }
        html.text-size-large {
            font-size: 24px !important;
        }

        /* Mode Kontras Tinggi */
        html.high-contrast {
            filter: contrast(125%);
        }
        html.high-contrast body {
            background-color: #ffffff !important;
            color: #000000 !important;
        }
        html.high-contrast a, 
        html.high-contrast button, 
        html.high-contrast .border-card {
            border: 2px solid #000000 !important;
        }

        /* Mode Sederhana */
        html.simple-mode * {
            animation: none !important;
            transition: none !important;
        }

        /* Ukuran target sentuh minimal 48px */
        .btn-touch {
            min-height: 48px;
            min-width: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Garis batas kartu sederhana */
        .border-card {
            border: 1px solid #e5e7eb;
        }

        /* Batasan lebar teks artikel untuk kenyamanan baca */
        .max-prose-desa {
            max-width: 70ch;
        }

        /* Gaya cetak surat */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; font-size: 12pt !important; color: black !important; }
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-krem-50 text-slate-800 font-sans antialiased" x-data="accessibilityControls()">

    <!-- ========================================================= -->
    <!-- 1. BAR AKSESIBILITAS (SATU BARIS BERSIH & RAPI, MAX 44PX) -->
    <!-- ========================================================= -->
    <div class="no-print bg-stone-100 text-slate-700 text-sm border-b border-stone-200">
        <div class="max-w-6xl mx-auto px-4 py-1.5 flex items-center justify-between gap-2 h-11">
            <!-- Label Kiri -->
            <div class="flex items-center gap-2 text-xs sm:text-sm font-normal text-slate-600">
                <svg class="w-4 h-4 text-desa-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <span>Aksesibilitas Tampilan</span>
            </div>

            <!-- Kontrol Desktop -->
            <div class="hidden sm:flex items-center gap-2 text-xs">
                <!-- Ukuran Font -->
                <div class="inline-flex rounded-md border border-stone-300 bg-white p-0.5" role="group" aria-label="Pilihan Ukuran Teks">
                    <button type="button" @click="setTextSize('normal')" :class="textSize === 'normal' ? 'bg-desa-700 text-white font-bold' : 'text-slate-700 hover:bg-stone-50'" class="px-2.5 py-1 rounded text-xs transition" title="Ukuran teks normal (18px)">
                        A
                    </button>
                    <button type="button" @click="setTextSize('medium')" :class="textSize === 'medium' ? 'bg-desa-700 text-white font-bold' : 'text-slate-700 hover:bg-stone-50'" class="px-2.5 py-1 rounded text-xs transition font-bold" title="Ukuran teks sedang (21px)">
                        A+
                    </button>
                    <button type="button" @click="setTextSize('large')" :class="textSize === 'large' ? 'bg-desa-700 text-white font-bold' : 'text-slate-700 hover:bg-stone-50'" class="px-2.5 py-1 rounded text-xs transition font-bold" title="Ukuran teks besar (24px)">
                        A++
                    </button>
                </div>

                <!-- Kontras Tinggi -->
                <button type="button" @click="toggleHighContrast()" :class="highContrast ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-50'" class="px-2.5 py-1 rounded-md text-xs transition">
                    <span x-text="highContrast ? 'Kontras: Aktif' : 'Kontras Tinggi'"></span>
                </button>

                <!-- Mode Sederhana -->
                <button type="button" @click="toggleSimpleMode()" :class="simpleMode ? 'bg-slate-900 text-white font-bold' : 'bg-white text-slate-700 border border-stone-300 hover:bg-stone-50'" class="px-2.5 py-1 rounded-md text-xs transition">
                    <span x-text="simpleMode ? 'Mode Sederhana: Aktif' : 'Mode Sederhana'"></span>
                </button>

                <!-- Tautan Bantuan -->
                <button type="button" @click="$dispatch('open-help-modal')" class="text-desa-700 font-bold hover:underline px-2 py-1 text-xs">
                    Bantuan
                </button>
            </div>

            <!-- Tombol Mobile Tampilan -->
            <div class="sm:hidden relative" x-data="{ openMobileSettings: false }">
                <button type="button" @click="openMobileSettings = !openMobileSettings" class="px-3 py-1 bg-white border border-stone-300 rounded text-xs font-bold text-slate-700 flex items-center gap-1">
                    <span>Tampilan</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <div x-show="openMobileSettings" @click.away="openMobileSettings = false" x-cloak class="absolute right-0 mt-1 w-56 bg-white border border-stone-300 rounded-md shadow-md p-3 z-50 space-y-2">
                    <div class="text-xs font-bold text-slate-700">Ukuran Huruf:</div>
                    <div class="flex gap-1">
                        <button type="button" @click="setTextSize('normal')" :class="textSize === 'normal' ? 'bg-desa-700 text-white' : 'bg-stone-100'" class="flex-1 py-1 text-xs rounded border">A</button>
                        <button type="button" @click="setTextSize('medium')" :class="textSize === 'medium' ? 'bg-desa-700 text-white' : 'bg-stone-100'" class="flex-1 py-1 text-xs rounded border font-bold">A+</button>
                        <button type="button" @click="setTextSize('large')" :class="textSize === 'large' ? 'bg-desa-700 text-white' : 'bg-stone-100'" class="flex-1 py-1 text-xs rounded border font-bold">A++</button>
                    </div>
                    <div class="pt-2 border-t border-stone-100 space-y-1">
                        <button type="button" @click="toggleHighContrast()" class="w-full text-left py-1 text-xs text-slate-700 hover:text-black">
                            <span x-text="highContrast ? 'Matikan Kontras Tinggi' : 'Nyalakan Kontras Tinggi'"></span>
                        </button>
                        <button type="button" @click="toggleSimpleMode()" class="w-full text-left py-1 text-xs text-slate-700 hover:text-black">
                            <span x-text="simpleMode ? 'Matikan Mode Sederhana' : 'Nyalakan Mode Sederhana'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- 2. HEADER PUTIH SATU BARIS (GARIS BAWAH UNTUK MENU AKTIF) -->
    <!-- ========================================================= -->
    <header class="no-print bg-white border-b border-stone-200 sticky top-0 z-40" x-data="{ mobileNav: false }">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Logo & Nama Desa Segaris -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 focus:outline-none focus:ring-2 focus:ring-desa-600 rounded">
                    <!-- Lambang Garis Minimalis -->
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-md bg-desa-700 text-white flex items-center justify-center font-bold text-base shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight whitespace-nowrap">
                            {{ config('desa.nama_desa') }}
                        </span>
                        <span class="text-[11px] text-stone-500 font-normal hidden md:inline">
                            Prototype tugas kuliah
                        </span>
                    </div>
                </a>

                <!-- Navigasi Desktop (Garis Bawah untuk Menu Aktif) -->
                <nav class="hidden lg:flex items-center gap-6 text-base">
                    <a href="{{ route('home') }}" class="py-2 transition {{ request()->routeIs('home') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                        Beranda
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="py-2 transition {{ request()->routeIs('dashboard') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                            Dashboard
                        </a>

                        @if(auth()->user()->isKades() || auth()->user()->isRtRw())
                            <a href="{{ route('penduduk.index') }}" class="py-2 transition {{ request()->routeIs('penduduk.*') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                                Data Warga
                            </a>
                        @endif

                        @if(auth()->user()->isKades() || auth()->user()->isKader())
                            <a href="{{ route('stunting.index') }}" class="py-2 transition {{ request()->routeIs('stunting.*') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                                Balita & Gizi
                            </a>
                        @endif
                    @endauth

                    <a href="{{ route('ktp-hilang.index') }}" class="py-2 transition {{ request()->routeIs('ktp-hilang.*') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                        Lapor KTP Hilang
                    </a>

                    <a href="{{ route('umkm.index') }}" class="py-2 transition {{ request()->routeIs('umkm.*') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                        Pasar UMKM
                    </a>

                    <a href="{{ route('gotong-royong.index') }}" class="py-2 transition {{ request()->routeIs('gotong-royong.*') ? 'border-b-2 border-desa-700 text-desa-700 font-bold' : 'text-slate-700 hover:text-desa-700 font-normal' }}">
                        Gotong Royong
                    </a>

                    <button type="button" @click="$dispatch('open-help-modal')" class="py-2 text-slate-700 hover:text-desa-700 font-normal">
                        Bantuan
                    </button>
                </nav>

                <!-- Tombol Masuk / Status Pengguna -->
                <div class="hidden lg:flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" type="button" class="btn-touch px-3 py-1.5 border border-stone-300 rounded-md hover:bg-stone-50 transition text-sm flex items-center gap-2">
                                <span class="font-bold text-slate-900">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-stone-500">({{ auth()->user()->role_label }})</span>
                                <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div x-show="dropdown" @click.away="dropdown = false" x-cloak class="absolute right-0 mt-1 w-56 bg-white border border-stone-200 rounded-md shadow-lg py-1 z-50 text-sm">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-slate-700 hover:bg-stone-100 font-normal">
                                    Dashboard
                                </a>
                                @if(auth()->user()->isKades())
                                    <a href="{{ route('audit-log.index') }}" class="block px-4 py-2 text-slate-700 hover:bg-stone-100 font-normal">
                                        Audit Log Desa
                                    </a>
                                @endif
                                <a href="{{ route('panduan.index') }}" class="block px-4 py-2 text-slate-700 hover:bg-stone-100 font-normal">
                                    Pusat Panduan
                                </a>
                                <div class="border-t border-stone-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-rose-700 hover:bg-rose-50 font-normal">
                                        Keluar Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-touch px-4 py-2 bg-desa-700 hover:bg-desa-800 text-white rounded-md text-sm font-bold transition">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Tombol Menu Mobile -->
                <div class="flex lg:hidden items-center gap-2">
                    <button @click="mobileNav = !mobileNav" type="button" class="btn-touch p-2 text-slate-700 hover:text-black" aria-label="Buka Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Mobile Panel -->
        <div x-show="mobileNav" x-cloak class="lg:hidden border-t border-stone-200 bg-white px-4 py-3 space-y-2 text-base">
            <a href="{{ route('home') }}" class="block py-2 {{ request()->routeIs('home') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Beranda</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block py-2 {{ request()->routeIs('dashboard') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Dashboard</a>
                @if(auth()->user()->isKades() || auth()->user()->isRtRw())
                    <a href="{{ route('penduduk.index') }}" class="block py-2 {{ request()->routeIs('penduduk.*') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Data Warga</a>
                @endif
                @if(auth()->user()->isKades() || auth()->user()->isKader())
                    <a href="{{ route('stunting.index') }}" class="block py-2 {{ request()->routeIs('stunting.*') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Balita & Gizi</a>
                @endif
            @endauth
            <a href="{{ route('ktp-hilang.index') }}" class="block py-2 {{ request()->routeIs('ktp-hilang.*') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Lapor KTP Hilang</a>
            <a href="{{ route('umkm.index') }}" class="block py-2 {{ request()->routeIs('umkm.*') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Pasar UMKM</a>
            <a href="{{ route('gotong-royong.index') }}" class="block py-2 {{ request()->routeIs('gotong-royong.*') ? 'font-bold text-desa-700' : 'text-slate-700' }}">Gotong Royong</a>
            <button type="button" @click="$dispatch('open-help-modal')" class="block w-full text-left py-2 text-slate-700">Bantuan</button>
            <div class="pt-2 border-t border-stone-100">
                @auth
                    <div class="py-1 text-xs text-stone-500">{{ auth()->user()->name }} ({{ auth()->user()->role_label }})</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="py-2 text-rose-700 font-bold text-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-center py-2.5 bg-desa-700 text-white rounded font-bold text-sm">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- ========================================================= -->
    <!-- 3. TOAST NOTIFIKASI KECIL (OTOMATIS HILANG DALAM 4 DETIK) -->
    <!-- ========================================================= -->
    <div class="no-print fixed top-24 right-4 z-50 space-y-2 max-w-sm w-full">
        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-cloak class="p-3 bg-white border-l-4 border-desa-600 border border-stone-200 rounded-md shadow-md text-sm text-slate-800 flex items-start justify-between gap-2">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-desa-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-stone-400 hover:text-black text-lg leading-none">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-cloak class="p-3 bg-white border-l-4 border-rose-600 border border-stone-200 rounded-md shadow-md text-sm text-slate-800 flex items-start justify-between gap-2">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-stone-400 hover:text-black text-lg leading-none">&times;</button>
            </div>
        @endif

        @if(session('info'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-cloak class="p-3 bg-white border-l-4 border-slate-700 border border-stone-200 rounded-md shadow-md text-sm text-slate-800 flex items-start justify-between gap-2">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-slate-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('info') }}</span>
                </div>
                <button @click="show = false" class="text-stone-400 hover:text-black text-lg leading-none">&times;</button>
            </div>
        @endif
    </div>

    <!-- ========================================================= -->
    <!-- 4. KONTEN UTAMA -->
    <!-- ========================================================= -->
    <main class="flex-grow">
        @if(!request()->routeIs('home'))
            <div class="no-print max-w-6xl mx-auto px-4 pt-4 pb-1">
                <nav class="flex items-center gap-1.5 text-xs text-stone-500" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-desa-700">Beranda</a>
                    <span>/</span>
                    @auth
                        <a href="{{ route('dashboard') }}" class="hover:text-desa-700">Dashboard</a>
                        <span>/</span>
                    @endauth
                    <span class="text-slate-800 font-bold">@yield('page_title', 'Halaman')</span>
                </nav>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- ========================================================= -->
    <!-- 5. FOOTER TENANG (TEKS RATA KIRI, GARIS PEMISAH 1PX) -->
    <!-- ========================================================= -->
    <footer class="no-print bg-stone-100 text-slate-700 pt-10 pb-8 border-t border-stone-300 mt-16 text-sm">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-8 border-b border-stone-200">
                <!-- Identitas -->
                <div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">{{ config('desa.nama_desa') }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-3">
                        {{ config('desa.deskripsi') }}
                    </p>
                    <p class="text-[11px] text-stone-500 font-normal">
                        Kec. {{ config('desa.kecamatan') }}, Kab. {{ config('desa.kabupaten') }}
                    </p>
                </div>

                <!-- Kontak Pelayanan -->
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2">Kantor Desa</h4>
                    <ul class="space-y-1.5 text-xs text-slate-600">
                        <li>{{ config('desa.alamat_kantor') }}</li>
                        <li>{{ config('desa.jam_pelayanan') }}</li>
                        <li>Telepon: {{ config('desa.telepon') }}</li>
                        <li>Surel: {{ config('desa.email') }}</li>
                    </ul>
                </div>

                <!-- Layanan Warga -->
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2">Layanan Warga</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="{{ route('ktp-hilang.create') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Lapor KTP Hilang</a></li>
                        <li><a href="{{ route('ktp-hilang.lacak') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Lacak Status Surat</a></li>
                        <li><a href="{{ route('umkm.index') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Pasar Produk UMKM</a></li>
                        <li><a href="{{ route('gotong-royong.index') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Kegiatan Gotong Royong</a></li>
                    </ul>
                </div>

                <!-- Etika & Panduan -->
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-2">Informasi</h4>
                    <ul class="space-y-1.5 text-xs">
                        <li><a href="{{ route('panduan.index') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Pusat Panduan</a></li>
                        <li><a href="{{ route('kebijakan-privasi') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Kebijakan Privasi (PDP)</a></li>
                        <li><a href="{{ route('tentang-sdgs') }}" class="text-slate-600 hover:text-desa-700 hover:underline">Keterkaitan SDGs Desa</a></li>
                        <li><button type="button" @click="$dispatch('open-help-modal')" class="text-slate-600 hover:text-desa-700 hover:underline">Bantuan Penggunaan</button></li>
                    </ul>
                </div>
            </div>

            <!-- Catatan Prototype Akademik -->
            <div class="pt-6 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-stone-500">
                <p>{{ config('desa.app_academic_note') }}</p>
                <p>&copy; {{ date('Y') }} {{ config('desa.nama_desa') }}</p>
            </div>
        </div>
    </footer>

    <!-- ========================================================= -->
    <!-- 6. MODAL BANTUAN SEDERHANA (DIBUKA VIA TAUTAN "BANTUAN") -->
    <!-- ========================================================= -->
    <div x-data="{ open: false }" @open-help-modal.window="open = true" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/50 flex items-center justify-center p-4">
        <div @click.away="open = false" class="bg-white rounded-lg max-w-lg w-full p-6 border border-stone-300 shadow-xl text-left relative">
            <div class="flex items-start justify-between pb-3 border-b border-stone-200 mb-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Bantuan Penggunaan</h3>
                    <p class="text-xs text-slate-500">Petunjuk ringkas penggunaan situs {{ config('desa.nama_desa') }}</p>
                </div>
                <button @click="open = false" class="text-stone-400 hover:text-black text-2xl font-bold leading-none">&times;</button>
            </div>

            <div class="space-y-4 text-sm text-slate-700 leading-relaxed">
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">1. Mengajukan Surat KTP Hilang:</h4>
                    <p class="text-xs text-slate-600">Buka menu <em>"Lapor KTP Hilang"</em> &rarr; isi formulir identitas &rarr; simpan Kode Lacak untuk memantau proses verifikasi.</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">2. Membaca Huruf Lebih Jelas:</h4>
                    <p class="text-xs text-slate-600">Gunakan tombol <strong>A+</strong> atau <strong>A++</strong> di bar atas untuk memperbesar ukuran huruf.</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-1">3. Kontak Kantor Desa:</h4>
                    <p class="text-xs text-slate-600">Hubungi telepon/WhatsApp di <strong>{{ config('desa.telepon') }}</strong> pada hari kerja (08.00 - 15.30 WIB).</p>
                </div>
            </div>

            <div class="mt-6 pt-3 border-t border-stone-200 flex justify-end">
                <button type="button" @click="open = false" class="btn-touch px-4 py-2 bg-stone-800 text-white rounded-md text-sm font-bold hover:bg-black transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script Aksesibilitas -->
    <script>
        function accessibilityControls() {
            return {
                textSize: localStorage.getItem('desa_text_size') || 'normal',
                highContrast: localStorage.getItem('desa_high_contrast') === 'true',
                simpleMode: localStorage.getItem('desa_simple_mode') === 'true',

                init() {
                    this.applySettings();
                },

                setTextSize(size) {
                    this.textSize = size;
                    localStorage.setItem('desa_text_size', size);
                    this.applySettings();
                },

                toggleHighContrast() {
                    this.highContrast = !this.highContrast;
                    localStorage.setItem('desa_high_contrast', this.highContrast);
                    this.applySettings();
                },

                toggleSimpleMode() {
                    this.simpleMode = !this.simpleMode;
                    localStorage.setItem('desa_simple_mode', this.simpleMode);
                    this.applySettings();
                },

                applySettings() {
                    const html = document.documentElement;
                    html.classList.remove('text-size-medium', 'text-size-large');
                    if (this.textSize === 'medium') html.classList.add('text-size-medium');
                    if (this.textSize === 'large') html.classList.add('text-size-large');

                    if (this.highContrast) {
                        html.classList.add('high-contrast');
                    } else {
                        html.classList.remove('high-contrast');
                    }

                    if (this.simpleMode) {
                        html.classList.add('simple-mode');
                    } else {
                        html.classList.remove('simple-mode');
                    }
                }
            }
        }
    </script>
</body>
</html>
