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

        $notifications = $user->notifications()
            ->latest()
            ->paginate(15);

        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
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

