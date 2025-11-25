<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display the current user's notifications.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $filterType = $request->query('type', 'all');
        $filterStatus = $request->query('status', 'all');

        $notificationsQuery = $user->notifications()
            ->latest();

        if ($filterType !== 'all' && filled($filterType)) {
            $notificationsQuery->where('type', $filterType);
        }

        if ($filterStatus === 'unread') {
            $notificationsQuery->whereNull('read_at');
        }

        $notifications = $notificationsQuery
            ->paginate(15)
            ->withQueryString();

        $unreadCount = $user->unreadNotifications()->count();
        $availableTypes = $user->notifications()
            ->select('type')
            ->distinct()
            ->pluck('type')
            ->filter()
            ->values();

        return view('notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'filterType' => $filterType,
            'filterStatus' => $filterStatus,
            'availableTypes' => $availableTypes,
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, Notification $notification): RedirectResponse
    {
        $this->ensureNotificationOwner($request, $notification);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back()->with('status', __('Notifikasi ditandai sudah dibaca.'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): RedirectResponse
    {
        $request->user()
            ->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('status', __('Semua notifikasi ditandai sudah dibaca.'));
    }

    /**
     * Ensure notification belongs to authenticated user.
     */
    protected function ensureNotificationOwner(Request $request, Notification $notification): void
    {
        if ($notification->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }
    }
}

