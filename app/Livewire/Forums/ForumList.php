<?php

namespace App\Livewire\Forums;

use App\Models\Forum;
use Livewire\Component;

class ForumList extends Component
{
    public function render()
    {
        $forums = Forum::withCount('topics')
            ->get()
            ->map(function ($forum) {
                $forum->latest_topic = $forum->latestTopic();
                return $forum;
            });

        return view('livewire.forums.forum-list', [
            'forums' => $forums,
        ]);
    }
}
