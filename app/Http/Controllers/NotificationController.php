<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function latest(Request $request): JsonResponse
    {
        $notifications = $request->user()->notifications()->latest()->take(10)->get()->map(fn ($notification) => [
            'id' => $notification->id,
            'title' => $notification->data['type'] ?? 'Notifikasi',
            'message' => $notification->data['message'] ?? '',
            'url' => route('notifications.read', $notification->id),
            'read_at' => $notification->read_at?->toIso8601String(),
            'created_at' => $notification->created_at->diffForHumans(),
        ]);

        return response()->json(['unread_count' => $request->user()->unreadNotifications()->count(), 'notifications' => $notifications]);
    }

    public function read(Request $request, string $notification): RedirectResponse
    {
        $item = $request->user()->notifications()->findOrFail($notification);
        $item->markAsRead();
        $url = $item->data['url'] ?? route('dashboard');

        // Older queued notifications can contain APP_URL from the worker.
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $url = parse_url($url, PHP_URL_PATH) ?: route('dashboard');
        }

        return redirect($url);
    }

    public function readAll(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back();
    }
}
