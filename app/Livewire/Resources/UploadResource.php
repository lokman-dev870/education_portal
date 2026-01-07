<?php

namespace App\Livewire\Resources;

use App\Models\Resource;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UploadResource extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $type = 'apuntes';
    public $career;
    public $subject;
    public $semester;
    public $tags = '';
    public $file;

    public $showModal = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'type' => 'required',
        'career' => 'required',
        'subject' => 'required',
        'semester' => 'nullable|integer|min:1|max:12',
        'file' => 'required|file|max:51200', // 50MB max
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['title', 'description', 'type', 'career', 'subject', 'semester', 'tags', 'file']);
    }

    public function save()
    {
        $this->validate();

        $path = $this->file->store('resources', 'public');

        $tagsArray = array_filter(array_map('trim', explode(',', $this->tags)));

        Resource::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'file_path' => $path,
            'file_name' => $this->file->getClientOriginalName(),
            'file_type' => $this->file->getClientOriginalExtension(),
            'file_size' => $this->file->getSize(),
            'career' => $this->career,
            'subject' => $this->subject,
            'semester' => $this->semester,
            'tags' => $tagsArray,
            'is_approved' => true, // Auto-aprobar por ahora
        ]);

        session()->flash('message', '¡Recurso subido exitosamente!');
        $this->closeModal();
        $this->dispatch('resource-uploaded');
    }

    public function render()
    {
        $careers = ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición', 'Farmacia'];
        $types = [
            'apuntes' => 'Apuntes',
            'presentacion' => 'Presentación',
            'articulo' => 'Artículo Científico',
            'guia' => 'Guía de Estudio',
            'examen' => 'Examen de Práctica',
            'otro' => 'Otro',
        ];

        return view('livewire.resources.upload-resource', [
            'careers' => $careers,
            'types' => $types,
        ]);
    }
}
