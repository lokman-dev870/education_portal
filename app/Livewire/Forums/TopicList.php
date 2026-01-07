<?php

namespace App\Livewire\Forums;

use App\Models\Forum;
use App\Models\ForumTopic;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class TopicList extends Component
{
    use WithPagination;

    public Forum $forum;
    
    #[Url]
    public $search = '';

    public $showCreateModal = false;
    public $title = '';
    public $content = '';

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
    ];

    public function mount($forumId)
    {
        $this->forum = Forum::findOrFail($forumId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->reset(['title', 'content']);
    }

    public function createTopic()
    {
        $this->validate();

        ForumTopic::create([
            'forum_id' => $this->forum->id,
            'user_id' => auth()->id(),
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->forum->increment('topics_count');

        session()->flash('message', '¡Tema creado exitosamente!');
        $this->closeCreateModal();
    }

    public function render()
    {
        $topics = ForumTopic::with(['user.studentProfile'])
            ->where('forum_id', $this->forum->id)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orderBy('is_pinned', 'desc')
            ->latest()
            ->paginate(15);

        return view('livewire.forums.topic-list', [
            'topics' => $topics,
        ]);
    }
}
