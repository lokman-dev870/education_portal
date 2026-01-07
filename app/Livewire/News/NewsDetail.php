<?php

namespace App\Livewire\News;

use App\Models\News;
use Livewire\Component;

class NewsDetail extends Component
{
    public News $news;

    public function mount($id)
    {
        $this->news = News::published()
            ->with('user')
            ->findOrFail($id);
        
        $this->news->incrementViews();
    }

    public function render()
    {
        $relatedNews = News::published()
            ->where('category', $this->news->category)
            ->where('id', '!=', $this->news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('livewire.news.news-detail', [
            'relatedNews' => $relatedNews,
        ]);
    }
}
