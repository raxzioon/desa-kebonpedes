<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->isKades()) {
            abort(403);
        }

        $query = AuditLog::query();

        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('deskripsi', 'like', "%{$keyword}%")
                  ->orWhere('user_name', 'like', "%{$keyword}%")
                  ->orWhere('ip_address', 'like', "%{$keyword}%");
            });
        }

        $auditLogs = $query->latest('created_at')->paginate(15)->withQueryString();
        $moduls = AuditLog::select('modul')->distinct()->pluck('modul');
        $aksis = AuditLog::select('aksi')->distinct()->pluck('aksi');

        return view('audit-log.index', compact('auditLogs', 'moduls', 'aksis', 'user'));
    }
}
