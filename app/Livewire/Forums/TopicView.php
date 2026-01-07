<?php

namespace App\Livewire\Forums;

use App\Models\ForumTopic;
use App\Models\ForumReply;
use Livewire\Component;
use Livewire\WithPagination;

class TopicView extends Component
{
    use WithPagination;

    public ForumTopic $topic;
    public $replyContent = '';
    public $replyingTo = null;

    protected $rules = [
        'replyContent' => 'required|min:5',
    ];

    public function mount($topicId)
    {
        $this->topic = ForumTopic::with(['forum', 'user.studentProfile'])->findOrFail($topicId);
        $this->topic->incrementViews();
    }

    public function replyTo($replyId = null)
    {
        $this->replyingTo = $replyId;
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyContent = '';
    }

    public function submitReply()
    {
        $this->validate();

        ForumReply::create([
            'topic_id' => $this->topic->id,
            'user_id' => auth()->id(),
            'content' => $this->replyContent,
            'parent_id' => $this->replyingTo,
        ]);

        $this->topic->increment('replies_count');
        $this->topic->forum->increment('posts_count');

        $this->reset(['replyContent', 'replyingTo']);
        session()->flash('message', '¡Respuesta publicada!');
    }

    public function markAsSolution($replyId)
    {
        if ($this->topic->user_id !== auth()->id()) {
            return;
        }

        ForumReply::where('topic_id', $this->topic->id)->update(['is_solution' => false]);
        ForumReply::find($replyId)->update(['is_solution' => true]);
        
        session()->flash('message', '¡Respuesta marcada como solución!');
    }

    public function render()
    {
        $replies = ForumReply::with(['user.studentProfile', 'replies.user.studentProfile'])
            ->where('topic_id', $this->topic->id)
            ->whereNull('parent_id')
            ->latest()
            ->paginate(10);

        return view('livewire.forums.topic-view', [
            'replies' => $replies,
        ]);
    }
}
