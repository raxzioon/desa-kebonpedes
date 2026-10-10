<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\AuditLog;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir masuk akun khusus perangkat desa & tombol demo
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Pastikan database dan seeder sudah terpasang
        try {
            if (!Schema::hasTable('users') || User::count() === 0) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            // Abaikan error saat build / non-blocking
        }

        $demoAccounts = [
            [
                'role_key' => 'kades',
                'title' => 'Kepala Desa',
                'name' => config('desa.nama_kades', 'Kepala Desa (contoh)'),
                'email' => 'kades@kebonpedes.desa.id',
                'desc' => 'Melihat seluruh data desa, persetujuan surat resmi, audit log, & kelola akun.',
                'badge' => 'bg-stone-100 text-slate-800 border-stone-300',
            ],
            [
                'role_key' => 'rt01',
                'title' => 'Ketua RT 01 / RW 01',
                'name' => 'Bpk. Cecep Supriatna',
                'email' => 'rt01@kebonpedes.desa.id',
                'desc' => 'Mengelola data penduduk, mutasi warga, & verifikasi KTP khusus wilayah RT 01.',
                'badge' => 'bg-stone-100 text-slate-800 border-stone-300',
            ],
            [
                'role_key' => 'rt02',
                'title' => 'Ketua RT 02 / RW 01',
                'name' => 'Bpk. Ujang Suherman',
                'email' => 'rt02@kebonpedes.desa.id',
                'desc' => 'Mengelola data warga RT 02, verifikasi permohonan surat wilayah RT 02.',
                'badge' => 'bg-stone-100 text-slate-800 border-stone-300',
            ],
            [
                'role_key' => 'kader',
                'title' => 'Kader Posyandu',
                'name' => 'Ibu Hj. Siti Nurhaliza',
                'email' => 'kader@kebonpedes.desa.id',
                'desc' => 'Pencatatan penimbangan balita, pemantauan status gizi, & intervensi stunting.',
                'badge' => 'bg-stone-100 text-slate-800 border-stone-300',
            ],
        ];

        return view('auth.login', compact('demoAccounts'));
    }

    /**
     * Proses autentikasi standar (email & password ter-hash)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Alamat surel (email) wajib diisi.',
            'email.email' => 'Format surel tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Auto seed if users table empty
        try {
            if (!Schema::hasTable('users') || User::count() === 0) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {}

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Akun Anda sedang dinonaktifkan oleh administrator.');
            }

            $request->session()->regenerate();

            // Catat ke Audit Log
            try {
                AuditLog::record(
                    'LOGIN',
                    'Autentikasi',
                    "Pengguna {$user->name} ({$user->role_label}) berhasil masuk ke dalam sistem."
                );
            } catch (\Throwable $e) {}

            return redirect()->intended(route('dashboard'))->with('success', "Selamat datang kembali, Bapak/Ibu {$user->name} ({$user->role_label}).");
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Fitur 1-Klik Masuk Cepat Khusus Demonstrasi Tugas Besar / Uji Coba
     */
    public function demoLogin(string $roleKey)
    {
        $emailMap = [
            'kades' => 'kades@kebonpedes.desa.id',
            'rt01' => 'rt01@kebonpedes.desa.id',
            'rt02' => 'rt02@kebonpedes.desa.id',
            'kader' => 'kader@kebonpedes.desa.id',
        ];

        if (!isset($emailMap[$roleKey])) {
            return redirect()->route('login')->with('error', 'Pilihan peran demo tidak ditemukan.');
        }

        $email = $emailMap[$roleKey];
        $user = null;

        try {
            $user = User::where('email', $email)->first();
        } catch (\Throwable $e) {
            // Table might not exist yet
        }

        // Jika user belum ada di database, jalankan seeder otomatis
        if (!$user) {
            try {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
                $user = User::where('email', $email)->first();
            } catch (\Throwable $e) {
                // Fallback pembuatan manual jika seeder error
            }
        }

        // Fallback penciptaan user instan jika seeder tidak mengembalikan data
        if (!$user) {
            $roleData = [
                'kades' => ['name' => config('desa.nama_kades', 'Kepala Desa (contoh)'), 'role' => 'kades', 'jabatan' => 'Kepala Desa Kebonpedes'],
                'rt01' => ['name' => 'Bpk. Cecep Supriatna', 'role' => 'rt_rw', 'rt' => '01', 'rw' => '01', 'jabatan' => 'Ketua RT 01 / RW 01'],
                'rt02' => ['name' => 'Bpk. Ujang Suherman', 'role' => 'rt_rw', 'rt' => '02', 'rw' => '01', 'jabatan' => 'Ketua RT 02 / RW 01'],
                'kader' => ['name' => 'Ibu Hj. Siti Nurhaliza', 'role' => 'kader', 'rt' => '01', 'rw' => '01', 'jabatan' => 'Ketua Kader Posyandu'],
            ];

            $data = $roleData[$roleKey] ?? ['name' => 'Pengguna Demo', 'role' => 'rt_rw', 'jabatan' => 'Perangkat Desa'];
            $user = User::create([
                'name' => $data['name'],
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => $data['role'],
                'rt' => $data['rt'] ?? null,
                'rw' => $data['rw'] ?? null,
                'jabatan' => $data['jabatan'],
                'is_active' => true,
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        try {
            AuditLog::record(
                'LOGIN_DEMO',
                'Autentikasi',
                "Masuk cepat mode demo sebagai {$user->name} ({$user->role_label})."
            );
        } catch (\Throwable $e) {}

        return redirect()->route('dashboard')->with('success', "Anda berhasil masuk sebagai {$user->name} ({$user->role_label}).");
    }

    /**
     * Proses keluar akun (Logout) & invalidasi session
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            try {
                AuditLog::record(
                    'LOGOUT',
                    'Autentikasi',
                    "Pengguna {$user->name} telah keluar dari sistem."
                );
            } catch (\Throwable $e) {}
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
