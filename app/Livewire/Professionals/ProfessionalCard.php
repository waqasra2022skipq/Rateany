<?php

namespace App\Livewire\Professionals;

use Livewire\Component;

class ProfessionalCard extends Component
{
    public $professional;

    public function render()
    {
        return view('livewire.professionals.professional-card');
    }
}
