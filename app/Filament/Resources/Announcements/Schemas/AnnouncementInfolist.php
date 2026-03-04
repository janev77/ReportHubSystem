<?php

namespace App\Filament\Resources\Announcements\Schemas;

use App\Models\Announcement;
use App\Models\User;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AnnouncementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('content')
                    ->columnSpanFull(),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('created_by')
                    ->label('Created By'),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('is_pinned')
                    ->boolean(),
                TextEntry::make('status')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'important' => 'Important',
                        'regular' => 'Regular',
                        default => 'None',
                    }),
                TextEntry::make('target')
                    ->label('Target')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'All Employees';
                        $decoded = is_array($state) ? $state : json_decode($state, true);
                        if (!$decoded || in_array('all', $decoded)) return 'All Employees';
                        return User::whereIn('id', $decoded)->pluck('email')->join(', ');
                    }),
//                TextEntry::make('publish_at')
//                    ->dateTime()
//                    ->placeholder('-'),
                TextEntry::make('expire_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Announcement $record): bool => $record->trashed()),
            ]);
    }
}
