<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class FeedController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('category')
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expire_at')
                    ->orWhere('expire_at', '>', now());
            })
            ->where(function ($query) {
                $query->whereJsonContains('target', 'all')
                    ->orWhereJsonContains('target', (string) auth()->id());
            })
            ->orderByRaw("JSON_EXTRACT(target, '$') = '[\"all\"]' DESC")
            ->latest()
            ->paginate(10);

        return response()->json($announcements);
    }
}
