<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $demoAccounts = [
            [
                'role_key' => 'kades',
                'title' => 'Kepala Desa',
                'name' => 'H. Asep Komarudin, S.Sos.',
                'email' => 'kades@kebonpedes.desa.id',
                'desc' => 'Melihat seluruh data desa, persetujuan surat resmi, audit log, & kelola akun.',
                'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'icon' => '🏛️',
            ],
            [
                'role_key' => 'rt01',
                'title' => 'Ketua RT 01 / RW 01',
                'name' => 'Bpk. Cecep Supriatna',
                'email' => 'rt01@kebonpedes.desa.id',
                'desc' => 'Mengelola data penduduk, mutasi warga, & verifikasi KTP khusus wilayah RT 01.',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
                'icon' => '🏡',
            ],
            [
                'role_key' => 'rt02',
                'title' => 'Ketua RT 02 / RW 01',
                'name' => 'Bpk. Ujang Suherman',
                'email' => 'rt02@kebonpedes.desa.id',
                'desc' => 'Mengelola data warga RT 02, verifikasi permohonan surat wilayah RT 02.',
                'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
                'icon' => '🏡',
            ],
            [
                'role_key' => 'kader',
                'title' => 'Kader Posyandu',
                'name' => 'Ibu Hj. Siti Nurhaliza',
                'email' => 'kader@kebonpedes.desa.id',
                'desc' => 'Pencatatan penimbangan balita, pemantauan status gizi, & intervensi stunting.',
                'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
                'icon' => '👶',
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->with('error', 'Akun Anda sedang dinonaktifkan oleh administrator.');
            }

            $request->session()->regenerate();

            // Catat ke Audit Log
            AuditLog::record(
                'LOGIN',
                'Autentikasi',
                "Pengguna {$user->name} ({$user->role_label}) berhasil masuk ke dalam sistem."
            );

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

        $user = User::where('email', $emailMap[$roleKey])->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Akun demo belum terpasang. Jalankan seeder.');
        }

        Auth::login($user);
        request()->session()->regenerate();

        AuditLog::record(
            'LOGIN_DEMO',
            'Autentikasi',
            "Masuk cepat mode demo sebagai {$user->name} ({$user->role_label})."
        );

        return redirect()->route('dashboard')->with('success', "Anda berhasil masuk sebagai {$user->name} ({$user->role_label}).");
    }

    /**
     * Proses keluar akun (Logout) & invalidasi session
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            AuditLog::record(
                'LOGOUT',
                'Autentikasi',
                "Pengguna {$user->name} telah keluar dari sistem."
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Anda telah berhasil keluar dari akun.');
    }
}
