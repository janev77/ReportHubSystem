<?php

namespace App\Filament\Resources\Announcements\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                TextColumn::make('created_by')
                    ->label('Created By')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('is_pinned')
                    ->boolean(),
                TextColumn::make('status')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'important' => 'Important',
                        'regular' => 'Regular',
                        default => 'None',
                    })
                    ->searchable(),
                TextColumn::make('target')
                    ->label('Target')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) return 'All Employees';
                        $decoded = is_array($state) ? $state : json_decode($state, true);
                        if (empty($decoded) || in_array('all', $decoded)) return 'All Employees';
                        $count = count($decoded);
                        return "{$count} " . str('Employee')->plural($count);
                    }),
//                TextColumn::make('publish_at')
//                    ->dateTime()
//                    ->sortable(),
                TextColumn::make('expire_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
