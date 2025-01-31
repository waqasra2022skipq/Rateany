<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use App\Models\Business;
use App\Models\Review;

class BusinessPage extends Component
{
    public $business;
    public $activeTab = 'reviews'; // Default active tab
    public $sortBy = 'newest'; // Default sorting

    public function mount($slug)
    {
        // Fetch business data

        $this->business = Business::where('slug', $slug)->with('reviews')->first();
        // dd($this->business);
    }

    public function render()
    {
        return view('livewire.businesses.business-page', [
            'business' => $this->business,
            'ratingBreakdown' => $this->getRatingBreakdown(),
            'reviews' => $this->getReviews()
        ]);
    }

    protected function getRatingBreakdown()
    {
        // Calculate rating breakdown (1-5 stars)
        $reviews = $this->business->reviews;
        $totalReviews = $this->business->reviews_count;
        $breakdown = [
            1 => $this->business->{'1_star_count'},
            2 => $this->business->{'2_star_count'},
            3 => $this->business->{'3_star_count'},
            4 => $this->business->{'4_star_count'},
            5 => $this->business->{'5_star_count'}
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
    }

    public function getReviews()
    {
        return Review::where('business_id', $this->business->id)
            ->when($this->sortBy === 'newest', function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when($this->sortBy === 'highest_rated', function ($query) {
                $query->orderBy('rating', 'desc');
            })
            ->when($this->sortBy === 'most_helpful', function ($query) {
                $query->orderBy('helpful_count', 'desc');
            })
            ->paginate(10); // 10 reviews per page
    }
}
