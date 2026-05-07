<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

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
                $target = json_encode([auth()->id()]);
                $query->whereJsonContains('target', 'all')
                    ->orWhereJsonContains('target', (string) auth()->id());
            })
            ->orderByRaw("JSON_EXTRACT(target, '$') = '[\"all\"]' DESC")
            ->latest()
            ->paginate(10);

        return view('feed.index', compact('announcements'));
    }
}
