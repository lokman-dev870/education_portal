<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use Carbon\Carbon;

class Calendar extends Component
{
    public $currentDate;
    public $events = [];
    public $selectedEvent = null;

    public $showCreateModal = false;
    public $title = '';
    public $description = '';
    public $type = 'examen';
    public $location = '';
    public $startDate = '';
    public $endDate = '';
    public $allDay = false;
    public $career = '';
    public $subject = '';
    public $isPublic = true;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'description' => 'nullable|max:1000',
        'type' => 'required',
        'location' => 'nullable|max:255',
        'startDate' => 'required|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
        'allDay' => 'boolean',
        'career' => 'nullable',
        'subject' => 'nullable',
        'isPublic' => 'boolean',
    ];

    public function mount()
    {
        $this->currentDate = Carbon::now()->format('Y-m-d');
        $this->loadEvents();
    }

    public function loadEvents()
    {
        $startOfMonth = Carbon::parse($this->currentDate)->startOfMonth();
        $endOfMonth = Carbon::parse($this->currentDate)->endOfMonth();

        $this->events = Event::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth]);
        })
        ->where(function ($query) {
            $query->where('is_public', true)
                  ->orWhere('user_id', auth()->id());
        })
        ->with('user')
        ->get()
        ->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->toIso8601String(),
                'end' => $event->end_date ? $event->end_date->toIso8601String() : null,
                'allDay' => $event->all_day,
                'color' => $event->color,
                'extendedProps' => [
                    'description' => $event->description,
                    'type' => $event->type,
                    'location' => $event->location,
                    'career' => $event->career,
                    'subject' => $event->subject,
                ],
            ];
        })->toArray();
    }

    public function previousMonth()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->subMonth()->format('Y-m-d');
        $this->loadEvents();
    }

    public function nextMonth()
    {
        $this->currentDate = Carbon::parse($this->currentDate)->addMonth()->format('Y-m-d');
        $this->loadEvents();
    }

    public function today()
    {
        $this->currentDate = Carbon::now()->format('Y-m-d');
        $this->loadEvents();
    }

    public function openCreateModal($date = null)
    {
        $this->showCreateModal = true;
        if ($date) {
            $this->startDate = $date;
        }
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->reset(['title', 'description', 'type', 'location', 'startDate', 'endDate', 'allDay', 'career', 'subject', 'isPublic']);
    }

    public function createEvent()
    {
        $this->validate();

        $color = match($this->type) {
            'examen' => '#ef4444',
            'entrega' => '#f59e0b',
            'seminario' => '#3b82f6',
            'conferencia' => '#8b5cf6',
            default => '#6b7280',
        };

        Event::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'location' => $this->location,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'all_day' => $this->allDay,
            'color' => $color,
            'career' => $this->career,
            'subject' => $this->subject,
            'is_public' => $this->isPublic,
        ]);

        $this->loadEvents();
        session()->flash('message', '¡Evento creado!');
        $this->closeCreateModal();
    }

    public function render()
    {
        $types = [
            'examen' => 'Examen',
            'entrega' => 'Entrega de Trabajo',
            'seminario' => 'Seminario',
            'conferencia' => 'Conferencia',
            'otro' => 'Otro',
        ];

        $careers = ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición', 'Farmacia'];

        return view('livewire.events.calendar', [
            'types' => $types,
            'careers' => $careers,
        ]);
    }
}
