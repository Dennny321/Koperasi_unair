<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Daftar semua log aktivitas dengan filter
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::with('user')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('subject_label', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($action = $request->get('action')) {
            $query->where('action', $action);
        }

        if ($module = $request->get('module')) {
            $query->where('module', $module);
        }

        if ($userId = $request->get('user_id')) {
            $query->where('user_id', $userId);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $perPage = in_array((int) $request->get('per_page', 10), [10, 25, 50, 100])
            ? (int) $request->get('per_page', 10)
            : 10;

        $logs    = $query->paginate($perPage)->withQueryString();
        $users   = User::orderBy('name')->get(['id', 'name', 'role']);
        $modules = ActivityLog::select('module')->distinct()->orderBy('module')->pluck('module');
        $actions = ['login', 'logout', 'create', 'update', 'delete', 'view'];

        $stats = [
            'total_today' => ActivityLog::today()->count(),
            'total_week'  => ActivityLog::where('created_at', '>=', now()->subDays(7))->count(),
            'total_all'   => ActivityLog::count(),
            'deletable'   => ActivityLog::olderThan3Months()->count(),
        ];

        return view('activity_log.index', compact('logs', 'users', 'modules', 'actions', 'stats'));
    }

    /**
     * Detail satu log aktivitas
     */
    public function show(ActivityLog $activityLog): View
    {
        return view('activity_log.show', ['log' => $activityLog]);
    }

    /**
     * Hapus log yang sudah berumur >= 3 bulan (bulk)
     */
    public function purgeOld(): RedirectResponse
    {
        $count = ActivityLog::olderThan3Months()->count();

        if ($count === 0) {
            return back()->with('info', 'Tidak ada log yang dapat dihapus (belum ada yang berumur 3 bulan).');
        }

        // Hapus langsung via query builder — bypass proteksi delete() model
        // karena sudah divalidasi oleh scope olderThan3Months
        ActivityLog::olderThan3Months()->delete();

        return back()->with('success', "Berhasil menghapus {$count} log aktivitas yang sudah berumur lebih dari 3 bulan.");
    }
}
