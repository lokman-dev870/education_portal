<?php

namespace App\Livewire\Resources;

use App\Models\Resource;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ResourceList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $type = '';
    
    #[Url]
    public $career = '';
    
    #[Url]
    public $subject = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $resources = Resource::with('user')
            ->where('is_approved', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('subject', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->type, fn($query) => $query->where('type', $this->type))
            ->when($this->career, fn($query) => $query->where('career', $this->career))
            ->when($this->subject, fn($query) => $query->where('subject', $this->subject))
            ->latest()
            ->paginate(12);

        $careers = Resource::distinct()->pluck('career')->filter();
        $types = ['apuntes', 'presentacion', 'articulo', 'guia', 'examen', 'otro'];

        return view('livewire.resources.resource-list', [
            'resources' => $resources,
            'careers' => $careers,
            'types' => $types,
        ]);
    }
}
