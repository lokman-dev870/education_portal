<?php

namespace App\Livewire\StudyGroups;

use App\Models\StudyGroup;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class StudyGroupList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $career = '';

    public $showCreateModal = false;
    public $name = '';
    public $description = '';
    public $subject = '';
    public $groupCareer = '';
    public $maxMembers = 10;
    public $isPublic = true;
    public $meetingLink = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'subject' => 'required',
        'groupCareer' => 'required',
        'maxMembers' => 'required|integer|min:2|max:50',
        'isPublic' => 'boolean',
        'meetingLink' => 'nullable|url',
    ];

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
        $this->reset(['name', 'description', 'subject', 'groupCareer', 'maxMembers', 'isPublic', 'meetingLink']);
    }

    public function createGroup()
    {
        $this->validate();

        $group = StudyGroup::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'description' => $this->description,
            'subject' => $this->subject,
            'career' => $this->groupCareer,
            'max_members' => $this->maxMembers,
            'is_public' => $this->isPublic,
            'meeting_link' => $this->meetingLink,
        ]);

        // Agregar al creador como miembro admin
        $group->members()->attach(auth()->id(), ['role' => 'admin']);

        session()->flash('message', '¡Grupo de estudio creado!');
        $this->closeCreateModal();
    }

    public function joinGroup($groupId)
    {
        $group = StudyGroup::findOrFail($groupId);

        if ($group->isFull()) {
            session()->flash('error', 'El grupo está lleno.');
            return;
        }

        if ($group->isMember(auth()->user())) {
            session()->flash('error', 'Ya eres miembro de este grupo.');
            return;
        }

        $group->members()->attach(auth()->id(), ['role' => 'member']);
        session()->flash('message', '¡Te has unido al grupo!');
    }

    public function render()
    {
        $groups = StudyGroup::with(['creator', 'members'])
            ->where('is_public', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('subject', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->career, fn($query) => $query->where('career', $this->career))
            ->latest()
            ->paginate(12);

        $careers = ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición', 'Farmacia'];

        return view('livewire.study-groups.study-group-list', [
            'groups' => $groups,
            'careers' => $careers,
        ]);
    }
}
