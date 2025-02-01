<?php

namespace App\Livewire\Professionals;

use Livewire\Component;
use App\Models\User;
use App\Models\Review;
use Livewire\WithPagination;

class ProfessionalPage extends Component
{
    use WithPagination;

    public $professional;
    public $activeTab = 'reviews'; // Default active tab
    public $sortBy = 'newest'; // Default sorting

    public function mount($slug)
    {
        // Fetch professional data

        $this->professional = User::where('username', $slug)->first();
        // dd($this->professional);
    }
    public function updated($propertyName)
    {
        // Reset pagination when a filter or search term is updated
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.professionals.professional-page', [
            'professional' => $this->professional,
            'ratingBreakdown' => $this->getRatingBreakdown(),
            'reviews' => $this->getReviews()
        ]);
    }

    protected function getRatingBreakdown()
    {
        // Calculate rating breakdown (1-5 stars)
        $reviews = $this->professional->reviews;
        $totalReviews = $this->professional->reviews_count;
        $breakdown = [
            1 => $this->professional->{'1_star_count'},
            2 => $this->professional->{'2_star_count'},
            3 => $this->professional->{'3_star_count'},
            4 => $this->professional->{'4_star_count'},
            5 => $this->professional->{'5_star_count'}
        ];
        // Convert to percentages
        foreach ($breakdown as $key => $count) {
            $breakdown[$key] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }

        return $breakdown;
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function sortReviews($sortBy)
    {
        $this->sortBy = $sortBy;
        $this->updated('sortBy');
    }

    public function getReviews()
    {
        return Review::where('user_id', $this->professional->id)
            ->when($this->sortBy === 'newest', function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when($this->sortBy === 'highest_rated', function ($query) {
                $query->orderBy('rating', 'desc');
            })
            ->when($this->sortBy === 'lowest_rated', function ($query) {
                $query->orderBy('rating', 'asc');
            })
            ->paginate(10); // 10 reviews per page
    }
}
