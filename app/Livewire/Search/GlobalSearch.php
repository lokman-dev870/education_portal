<?php

namespace App\Livewire\Search;

use App\Models\Resource;
use App\Models\ForumTopic;
use App\Models\News;
use App\Models\Event;
use Livewire\Component;
use Livewire\Attributes\Url;

class GlobalSearch extends Component
{
    #[Url]
    public $query = '';
    
    #[Url]
    public $type = 'all'; // all, resources, forums, news, events

    public $results = [];

    public function updatedQuery()
    {
        $this->search();
    }

    public function updatedType()
    {
        $this->search();
    }

    public function search()
    {
        if (strlen($this->query) < 2) {
            $this->results = [];
            return;
        }

        $this->results = [
            'resources' => [],
            'forum_topics' => [],
            'news' => [],
            'events' => [],
        ];

        if ($this->type === 'all' || $this->type === 'resources') {
            $this->results['resources'] = Resource::where('is_approved', true)
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->query . '%')
                      ->orWhere('description', 'like', '%' . $this->query . '%')
                      ->orWhere('subject', 'like', '%' . $this->query . '%')
                      ->orWhere('career', 'like', '%' . $this->query . '%');
                })
                ->with('user')
                ->limit(10)
                ->get();
        }

        if ($this->type === 'all' || $this->type === 'forums') {
            $this->results['forum_topics'] = ForumTopic::where(function ($q) {
                    $q->where('title', 'like', '%' . $this->query . '%')
                      ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->with(['user', 'forum'])
                ->limit(10)
                ->get();
        }

        if ($this->type === 'all' || $this->type === 'news') {
            $this->results['news'] = News::published()
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->query . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->query . '%')
                      ->orWhere('content', 'like', '%' . $this->query . '%');
                })
                ->limit(10)
                ->get();
        }

        if ($this->type === 'all' || $this->type === 'events') {
            $this->results['events'] = Event::where('is_public', true)
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->query . '%')
                      ->orWhere('description', 'like', '%' . $this->query . '%');
                })
                ->limit(10)
                ->get();
        }
    }

    public function render()
    {
        $totalResults = collect($this->results)->sum(fn($items) => $items->count());

        return view('livewire.search.global-search', [
            'totalResults' => $totalResults,
        ]);
    }
}
