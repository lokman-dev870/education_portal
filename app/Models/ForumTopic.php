<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_id',
        'user_id',
        'title',
        'content',
        'is_pinned',
        'is_locked',
        'views',
        'replies_count',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function forum(): BelongsTo
    {
        return $this->belongsTo(Forum::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'topic_id');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function latestReply()
    {
        return $this->replies()->latest()->first();
    }
}
