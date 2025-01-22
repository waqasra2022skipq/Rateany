<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryPage extends Component
{
    use WithPagination;
    public $pageTitle;
    public $metaDescription;

    public $category;
    public $relatedCategories;

    public $search = '';
    public $location = '';
    protected $queryString = ['search', 'location'];

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->firstOrFail();
        $slug = str_replace('-', ' ', $slug);
        $this->pageTitle = ucwords($slug);

        $this->metaDescription = "Find the {$this->pageTitle} on RateAny.co. Read reviews, compare ratings, and choose trusted businesses today.";

        // Fetch related categories
        $this->relatedCategories = Category::where('id', '!=', $this->category->id)
            ->inRandomOrder()
            ->take(6)
            ->get();
    }

    public function updated($propertyName)
    {
        // Reset pagination when a filter or search term is updated
        $this->resetPage();
    }

    public function render()
    {
        // Fetch businesses in the category with search filters
        $businesses = $this->category->businesses()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->withSmartScore()
            ->orderBy('smart_score', 'desc')
            ->paginate(4);

        return view('livewire.businesses.category-page', [
            'category' => $this->category,
            'businesses' => $businesses,
            'relatedCategories' => $this->relatedCategories,
        ])->layout('components.layouts.app', ['pageTitle' => $this->pageTitle, 'metaDescription' => $this->metaDescription]);
    }
}
