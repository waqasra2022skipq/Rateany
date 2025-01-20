<?php

namespace App\Livewire\Professionals;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Profession;


class Professions extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updated($propertyName)
    {
        // Reset pagination when a filter or search term is updated
        $this->resetPage();
    }

    public function render()
    {
        $professions = Profession::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(12);
        return view('livewire.professionals.professions', ['professions' => $professions]);
    }
}
