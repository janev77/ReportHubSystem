<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRolesEnum;
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(100),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->password()
                ->revealable()
                ->dehydrateStateUsing(fn($state) => \Illuminate\Support\Facades\Hash::make($state))
                ->dehydrated(fn($state) => filled($state))
                ->required(fn(string $operation) => $operation === 'create')
                ->label(fn(string $operation) => $operation === 'edit'
                    ? 'New Password (leave blank to keep)'
                    : 'Password'),

            Select::make('role')
                ->options(UserRolesEnum::class)
                ->default('employee')
                ->required(),

            Select::make('department')
                ->label('Department')
                ->options(fn() => Category::where('is_active', true)->pluck('name', 'name'))
                ->placeholder('Select a department'),

            Toggle::make('is_active')
                ->default(true)
                ->inline(false),
        ]);
    }
}
