<?php

namespace App\Livewire\Profile;

use App\Models\StudentProfile;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;

    public $career;
    public $university;
    public $semester;
    public $bio;
    public $phone;
    public $interests = '';
    public $avatar;

    public function mount()
    {
        $profile = auth()->user()->studentProfile;
        
        if ($profile) {
            $this->career = $profile->career;
            $this->university = $profile->university;
            $this->semester = $profile->semester;
            $this->bio = $profile->bio;
            $this->phone = $profile->phone;
            $this->interests = is_array($profile->interests) ? implode(', ', $profile->interests) : '';
        }
    }

    protected $rules = [
        'career' => 'required',
        'university' => 'nullable|max:255',
        'semester' => 'nullable|integer|min:1|max:12',
        'bio' => 'nullable|max:500',
        'phone' => 'nullable|max:20',
        'interests' => 'nullable',
        'avatar' => 'nullable|image|max:2048',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'career' => $this->career,
            'university' => $this->university,
            'semester' => $this->semester,
            'bio' => $this->bio,
            'phone' => $this->phone,
            'interests' => array_filter(array_map('trim', explode(',', $this->interests))),
        ];

        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        StudentProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        session()->flash('message', '¡Perfil actualizado exitosamente!');
    }

    public function render()
    {
        $careers = ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición', 'Farmacia', 'Otra'];
        
        return view('livewire.profile.edit-profile', [
            'careers' => $careers,
        ]);
    }
}
