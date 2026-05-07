<?php

namespace App\Filament\Widgets;

use App\Models\Announcement;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Announcements', Announcement::count()),
            Stat::make('Active Announcements', Announcement::where('is_active', true)->count()),
            Stat::make('Total Users', User::count()),

        ];
    }
}
