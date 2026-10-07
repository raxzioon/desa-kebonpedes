<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuditLog;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk dengan akun perangkat desa terlebih dahulu.');
        }

        $user = auth()->user();

        // Cek jika akun dinonaktifkan
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda sedang dinonaktifkan. Hubungi Kepala Desa.');
        }

        // Support string role terpisah koma maupun parameter ganda
        $allowedRoles = [];
        foreach ($roles as $r) {
            $allowedRoles = array_merge($allowedRoles, explode(',', $r));
        }
        $allowedRoles = array_map('trim', $allowedRoles);

        if (!in_array($user->role, $allowedRoles)) {
            // Catat pelanggaran akses di Audit Log demi etika profesi & keamanan
            AuditLog::record(
                'AKSES_DITOLAK',
                'Keamanan',
                "Percobaan akses tidak berwenang ke rute [{$request->path()}] oleh pengguna {$user->name} (Peran: {$user->role_label}). Hak akses yang dibutuhkan: " . implode(', ', $allowedRoles)
            );

            return response()->view('errors.403', [
                'user' => $user,
                'requiredRoles' => $allowedRoles,
                'attemptedPath' => $request->path(),
            ], 403);
        }

        return $next($request);
    }
}
