<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forum extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'icon',
        'topics_count',
        'posts_count',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function latestTopic()
    {
        return $this->topics()->latest()->first();
    }
}
