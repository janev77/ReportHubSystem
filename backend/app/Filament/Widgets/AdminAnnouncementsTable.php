<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use Filament\Widgets\Widget;

class AdminAnnouncementsTable extends Widget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected string $view = 'filament.widgets.admin-announcements';

    protected function getViewData(): array
    {
        $announcements = Announcement::query()
            ->with('category')
            ->orderByDesc('is_pinned')
            ->latest('created_at')
            ->get();

        return compact('announcements');
    }
}
