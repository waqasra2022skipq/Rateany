<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class BusinessesList extends Component
{
    use WithPagination;

    public $search = '';
    public $location = '';
    public $category = '';
    public $categories;
    public $currentCat;

    public $pageTitle = "Find Top-Rated Businesses | RateAny";
    public $metaDescription = "Explore and search for top-rated businesses by name, location, and category on RateAny.";


    protected $queryString = ['search', 'location', 'category'];


    public function mount()
    {
        // Load all categories for the category filter dropdown
        $this->categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });
    }

    public function updated($propertyName)
    {
        // Reset pagination when search or filters are updated
        $this->resetPage();
    }

    public function render()
    {

        $businesses = Business::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->when($this->category, function ($query) {
                $this->currentCat = Category::where('name', $this->category)->first();
                if ($this->currentCat) {
                    $query->where('categoryId', $this->currentCat->id);
                }
            })
            ->withSmartScore()
            ->orderBy('smart_score', 'desc')
            ->paginate(8);

        return view('livewire.businesses.businesses-list', [
            'businesses' => $businesses,
            'currentCat' => $this->currentCat
        ])->layout('components.layouts.app', [
            'pageTitle' => $this->pageTitle,
            'metaDescription' => $this->metaDescription,
        ]);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->location = '';
        $this->category = '';
    }
}
