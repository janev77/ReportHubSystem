<?php

namespace App\Models;

use App\Enums\UserRolesEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{

    use HasFactory, Notifiable, HasApiTokens;


    protected $casts = [
        'role' => UserRolesEnum::class,
    ];
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRolesEnum::class,
            'is_active' => 'boolean',
        ];
    }
    public function announcements()
    {
        return $this->belongsToMany(Announcement::class)
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }

    public function createdAnnouncements()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role->canAccessAdmin();
    }
}
