<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'career',
        'subject',
        'semester',
        'tags',
        'downloads',
        'is_approved',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_approved' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(ResourceRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function incrementDownloads()
    {
        $this->increment('downloads');
    }
}
