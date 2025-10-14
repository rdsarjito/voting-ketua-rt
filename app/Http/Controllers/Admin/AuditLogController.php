<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = AuditLog::with('user')
            ->when($request->filled('action'), fn($q) => $q->where('action', $request->string('action')))
            ->when($request->filled('user_id'), fn($q) => $q->where('user_id', $request->integer('user_id')))
            ->when($request->filled('model_type'), fn($q) => $q->where('model_type', $request->string('model_type')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.audit-logs.index', compact('logs'));
    }
}
