<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackupLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index(Request $request)
    {
        $query = BackupLog::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('backup_type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->backup_type) {
            $query->where('backup_type', $request->backup_type);
        }

        $backupLogs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.backup.index', compact('backupLogs'));
    }

    public function show(BackupLog $backupLog): JsonResponse
    {
        return response()->json([
            'success' => true,
            'backupLog' => $backupLog,
        ]);
    }

    public function createBackup(): JsonResponse
    {
        $backupLog = BackupLog::create([
            'backup_type' => 'database',
            'status' => 'pending',
            'notes' => 'Manual backup initiated by admin.',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Backup initiated successfully.',
            'backupLog' => $backupLog,
        ]);
    }
}
