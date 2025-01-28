<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use App\Models\Business;

class BusinessPage extends Component
{
    public $business;

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
}
