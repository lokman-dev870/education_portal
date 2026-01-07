<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relaciones del portal educativo
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function resourceRatings()
    {
        return $this->hasMany(ResourceRating::class);
    }

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }

    public function createdStudyGroups()
    {
        return $this->hasMany(StudyGroup::class);
    }

    public function studyGroups()
    {
        return $this->belongsToMany(StudyGroup::class, 'study_group_members')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function attendingEvents()
    {
        return $this->belongsToMany(Event::class, 'event_attendees')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
