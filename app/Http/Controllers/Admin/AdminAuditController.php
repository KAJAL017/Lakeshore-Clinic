<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminAuditController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('module', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->module) {
            $query->where('module', $request->module);
        }

        if ($request->action) {
            $query->where('action', $request->action);
        }

        $auditLogs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.audit.index', compact('auditLogs'));
    }

    public function store(Request $request): JsonResponse
    {
        $auditLog = AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $request->action,
            'module' => $request->module,
            'reference' => $request->reference,
            'description' => $request->description,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'auditLog' => $auditLog,
        ]);
    }

    public static function log(string $action, string $module, ?string $reference = null, ?string $description = null): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'reference' => $reference,
            'description' => $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
