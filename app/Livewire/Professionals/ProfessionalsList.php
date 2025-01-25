<?php

namespace App\Livewire\Professionals;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ProfessionalsList extends Component
{
    use WithPagination;

    public $search = '';
    public $location = '';
    public $profession = '';
    public $professions;
    public $currentProf;

    public $pageTitle = "Find Top-Rated Professionals | RateAny";
    public $metaDescription = "Explore and search for top-rated professionals by name, location, and profession on RateAny.";


    protected $queryString = ['search', 'location', 'profession'];


    public function mount()
    {
        // Load all categories for the category filter dropdown
        $this->professions = Cache::remember('profession', 60 * 60, function () {
            return profession::all();
        });
    }

    public function updated($propertyName)
    {
        // Reset pagination when search or filters are updated
        $this->resetPage();
    }

    public function render()
    {

        $professionals = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->when($this->profession, function ($query) {
                $this->currentProf = Profession::where('name', $this->profession)->first();
                if ($this->currentProf) {
                    $query->where('profession_id', $this->currentProf->id);
                }
            })
            ->withSmartScore()
            ->orderBy('smart_score', 'desc')
            ->paginate(8);

        return view('livewire.professionals.professionals-list', [
            'professionals' => $professionals,
            'currentProf' => $this->currentProf
        ])->layout('components.layouts.app', [
            'pageTitle' => $this->pageTitle,
            'metaDescription' => $this->metaDescription,
        ]);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->location = '';
        $this->profession = '';
    }
}
