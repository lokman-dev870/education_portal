<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'user_id',
        'content',
        'parent_id',
        'is_solution',
    ];

    protected $casts = [
        'is_solution' => 'boolean',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumReply::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'parent_id');
    }
}
