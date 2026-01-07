<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class LiveNotifications extends Component
{
    public $newContentCount = 0;
    public $showBanner = false;
    
    public function mount()
    {
        $this->checkNewContent();
    }
    
    #[On('check-new-content')]
    public function checkNewContent()
    {
        // Simular contenido nuevo desde la última visita (últimos 5 minutos)
        $recentTime = now()->subMinutes(5);
        
        $newTopics = \App\Models\ForumTopic::where('created_at', '>=', $recentTime)->count();
        $newResources = \App\Models\Resource::where('created_at', '>=', $recentTime)->count();
        $newNews = \App\Models\News::where('created_at', '>=', $recentTime)->count();
        
        $this->newContentCount = $newTopics + $newResources + $newNews;
        $this->showBanner = $this->newContentCount > 0;
    }
    
    public function dismissBanner()
    {
        $this->showBanner = false;
        $this->newContentCount = 0;
    }
    
    public function refreshContent()
    {
        $this->dispatch('activity-updated');
        $this->dismissBanner();
        $this->dispatch('content-refreshed');
    }
    
    public function render()
    {
        return view('livewire.live-notifications');
    }
}
