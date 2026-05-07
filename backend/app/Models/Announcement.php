<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'created_by',
        'publish_at',
        'expire_at',
        'is_active',
        'is_pinned',
        'status',
        'target',
    ];

    protected $attributes = [
        'target' => '["all"]',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'expire_at' => 'datetime',
        'is_active' => 'boolean',
        'is_pinned' => 'boolean',
        'target' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'email');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }
}
