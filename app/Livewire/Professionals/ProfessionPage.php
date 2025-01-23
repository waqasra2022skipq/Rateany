<?php

namespace App\Livewire\Professionals;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Profession;

class ProfessionPage extends Component
{
    use WithPagination;
    public $pageTitle;
    public $metaDescription;

    public $profession;
    public $relatedProfessions;

    public $search = '';
    public $location = '';

    protected $queryString = ['search', 'location'];

    public function mount($slug)
    {
        $this->profession = Profession::where('slug', $slug)->firstOrFail();
        $slug = str_replace('-', ' ', $slug);
        $this->pageTitle = ucwords($slug);
        $this->metaDescription = "Discover the {$this->pageTitle} on RateAny.co. Compare reviews, ratings, and find trusted legal professionals.";

        // Fetch related categories
        $this->relatedProfessions = Profession::where('id', '!=', $this->profession->id)
            ->inRandomOrder()
            ->take(6)
            ->get();
    }

    public function updated($propertyName)
    {
        // Reset pagination when a filter or search term is updated
        $this->resetPage();
    }

    public function updatedLocation($location)
    {
        // Reset pagination when location is updated
        $this->location =  $location;
    }

    public function render()
    {
        // Fetch businesses in the category with search filters
        $professionals = $this->profession->professionals()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->withSmartScore()
            ->orderBy('smart_score', 'desc')
            ->paginate(4);

        return view('livewire.professionals.profession-page', [
            'profession' => $this->profession,
            'professionals' => $professionals,
            'relatedProfessions' => $this->relatedProfessions,
        ])->layout(
            'components.layouts.app',
            [
                'pageTitle' => $this->pageTitle,
                'metaDescription' => $this->metaDescription
            ]
        );
    }
}
