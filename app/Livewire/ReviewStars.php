<?php

namespace App\Livewire;

use Livewire\Component;

class ReviewStars extends Component
{
    public $entity;
    public function render()
    {
        return view('livewire.review-stars');
    }
}
