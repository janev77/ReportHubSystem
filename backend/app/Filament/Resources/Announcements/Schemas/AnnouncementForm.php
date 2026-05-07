<?php

namespace App\Filament\Resources\Announcements\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->required()
                    ->relationship('category', 'name'),
                TextInput::make('created_by')
                    ->required()
                    ->default(fn () => Auth::user()->email)
                    ->disabled()
                    ->dehydrated(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_pinned')
                    ->required()
                    ->default(false),
                Select::make('status')
                    ->options([
                        'important' => 'Important',
                        'regular' => 'Regular',
                        '' => 'None',
                    ])
                    ->default('regular')
                    ->dehydrated(),
                Select::make('target')
                    ->required()
                    ->multiple()
                    ->options(fn () => ['all' => 'All Employees'] + User::pluck('email', 'id')->toArray())
                    ->default(['all'])
                    ->searchable()
                    ->dehydrated(),
//                DateTimePicker::make('publish_at'),
                DateTimePicker::make('expire_at'),
            ]);
    }
}
