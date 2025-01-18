<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;


class Categories extends Component
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
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(12);
        return view('livewire.businesses.categories', ['categories' => $categories]);
    }
}
