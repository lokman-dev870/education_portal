<?php

namespace App\Livewire;

use App\Models\ForumTopic;
use App\Models\Resource;
use App\Models\News;
use App\Models\Event;
use App\Models\StudyGroup;
use Livewire\Component;
use Livewire\Attributes\On;

class ActivityFeed extends Component
{
    public $activities = [];
    public $limit = 30;
    
    public function mount()
    {
        $this->loadActivities();
    }
    
    #[On('activity-updated')]
    public function loadActivities()
    {
        $activities = collect();
        
        // Temas de foro recientes
        $topics = ForumTopic::with(['user', 'forum'])
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($topic) {
                return [
                    'type' => 'forum_topic',
                    'icon' => '💬',
                    'color' => 'blue',
                    'user' => $topic->user->name,
                    'action' => 'creó un tema',
                    'title' => $topic->title,
                    'subtitle' => 'en ' . $topic->forum->name,
                    'url' => route('forums.topic', $topic->id),
                    'time' => $topic->created_at,
                    'meta' => $topic->views . ' vistas • ' . $topic->replies_count . ' respuestas',
                ];
            });
        
        // Recursos recientes
        $resources = Resource::with('user')
            ->where('is_approved', true)
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($resource) {
                return [
                    'type' => 'resource',
                    'icon' => '📚',
                    'color' => 'green',
                    'user' => $resource->user->name,
                    'action' => 'compartió',
                    'title' => $resource->title,
                    'subtitle' => $resource->subject . ' • ' . $resource->career,
                    'url' => route('resources.show', $resource->id),
                    'time' => $resource->created_at,
                    'meta' => $resource->downloads . ' descargas',
                ];
            });
        
        // Noticias recientes
        $news = News::with('user')
            ->where('is_published', true)
            ->latest('published_at')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'news',
                    'icon' => $item->is_featured ? '⭐' : '📰',
                    'color' => 'purple',
                    'user' => $item->user->name,
                    'action' => 'publicó',
                    'title' => $item->title,
                    'subtitle' => $item->excerpt,
                    'url' => route('news.show', $item->id),
                    'time' => $item->published_at,
                    'meta' => $item->views . ' vistas',
                ];
            });
        
        // Eventos próximos
        $events = Event::with('user')
            ->where('start_date', '>=', now()->subDays(2))
            ->orderBy('start_date')
            ->take(10)
            ->get()
            ->map(function ($event) {
                return [
                    'type' => 'event',
                    'icon' => '📅',
                    'color' => 'orange',
                    'user' => $event->user->name,
                    'action' => 'programó',
                    'title' => $event->title,
                    'subtitle' => $event->start_date->format('d M, H:i') . ' • ' . $event->location,
                    'url' => route('calendar.index'),
                    'time' => $event->created_at,
                    'meta' => $event->career,
                ];
            });
        
        // Grupos de estudio
        $groups = StudyGroup::with('user')
            ->where('is_public', true)
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($group) {
                $memberCount = $group->members()->count();
                return [
                    'type' => 'study_group',
                    'icon' => '👥',
                    'color' => 'indigo',
                    'user' => $group->user->name,
                    'action' => 'creó el grupo',
                    'title' => $group->name,
                    'subtitle' => $group->subject . ' • ' . $group->career,
                    'url' => route('study-groups.index'),
                    'time' => $group->created_at,
                    'meta' => $memberCount . '/' . $group->max_members . ' miembros',
                ];
            });
        
        // Combinar y ordenar todas las actividades
        $this->activities = $activities
            ->concat($topics)
            ->concat($resources)
            ->concat($news)
            ->concat($events)
            ->concat($groups)
            ->sortByDesc('time')
            ->take($this->limit)
            ->values()
            ->toArray();
    }
    
    public function render()
    {
        return view('livewire.activity-feed');
    }
}
