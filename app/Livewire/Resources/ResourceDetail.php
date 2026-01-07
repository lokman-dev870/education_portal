<?php

namespace App\Livewire\Resources;

use App\Models\Resource;
use App\Models\ResourceRating;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class ResourceDetail extends Component
{
    public Resource $resource;
    public $rating = 0;
    public $comment = '';

    public function mount($id)
    {
        $this->resource = Resource::with(['user.studentProfile', 'ratings.user'])->findOrFail($id);
    }

    public function download()
    {
        // Check if file exists
        if (!Storage::disk('public')->exists($this->resource->file_path)) {
            session()->flash('error', 'El archivo no está disponible. Este es un recurso de demostración.');
            return;
        }

        $this->resource->incrementDownloads();
        return Storage::disk('public')->download($this->resource->file_path, $this->resource->file_name);
    }

    public function submitRating()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|max:500',
        ]);

        ResourceRating::updateOrCreate(
            [
                'resource_id' => $this->resource->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]
        );

        $this->resource->refresh();
        session()->flash('message', '¡Valoración guardada!');
        $this->reset(['rating', 'comment']);
    }

    public function render()
    {
        $userRating = ResourceRating::where('resource_id', $this->resource->id)
            ->where('user_id', auth()->id())
            ->first();

        return view('livewire.resources.resource-detail', [
            'userRating' => $userRating,
        ]);
    }
}
