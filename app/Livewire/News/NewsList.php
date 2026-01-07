<?php

namespace App\Livewire\News;

use App\Models\News;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class NewsList extends Component
{
    use WithPagination;

    #[Url]
    public $category = '';

    public function render()
    {
        $news = News::published()
            ->with('user')
            ->when($this->category, fn($query) => $query->where('category', $this->category))
            ->latest('published_at')
            ->paginate(9);

        $featured = News::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        $categories = [
            'general' => 'General',
            'academico' => 'Académico',
            'evento' => 'Eventos',
            'importante' => 'Importante',
        ];

        return view('livewire.news.news-list', [
            'news' => $news,
            'featured' => $featured,
            'categories' => $categories,
        ]);
    }
}
