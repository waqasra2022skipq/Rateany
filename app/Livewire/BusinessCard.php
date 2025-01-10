<?php

namespace App\Livewire;

use Livewire\Component;

class BusinessCard extends Component
{
    public $business;
    public function render()
    {
        return view('livewire.business-card');
    }
}
