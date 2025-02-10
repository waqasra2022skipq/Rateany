<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use App\Models\Business;
use App\Models\Review;
use Livewire\WithPagination;

class BusinessPage extends Component
{
    use WithPagination;

    public $business;
    public $activeTab = 'reviews'; // Default active tab
    public $sortBy = 'newest'; // Default sorting
    public $pageTitle;
    public $metaDescription;

    public function mount($slug)
    {
        // Fetch business data

        $this->business = Business::where('slug', $slug)->first();

        $this->pageTitle = $this->business->name;
        $this->metaDescription = $this->business->description;
    }
    public function updated($propertyName)
    {
        // Reset pagination when a filter or search term is updated
        $this->resetPage();
    }

    public function render()
    {

        $schemaMarkup = $this->getSchemaMarkup();
        return view('livewire.businesses.business-page', [
            'business' => $this->business,
            'ratingBreakdown' => $this->getRatingBreakdown(),
            'reviews' => $this->getReviews()
        ])->layout(
            'components.layouts.app',
            ['pageTitle' => $this->pageTitle, 'metaDescription' => $this->metaDescription, 'schemaMarkup' =>  $schemaMarkup]
        );
    }

    protected function getRatingBreakdown()
    {
        // Calculate rating breakdown (1-5 stars)
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
        $this->updated('sortBy');
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
            ->when($this->sortBy === 'lowest_rated', function ($query) {
                $query->orderBy('rating', 'asc');
            })
            ->paginate(10); // 10 reviews per page
    }

    public function getSchemaMarkup()
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => $this->getBusinessSchemaType(),
            "@id" => route('businesses.show', ['slug' => $this->business->slug]),
            "name" => $this->business->name,
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $this->business->location,
            ],
            "url" => route('businesses.show', ['slug' => $this->business->slug]),
            "image" => [$this->business->business_logo],
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => round($this->business->average_rating, 1),
                "ratingCount" => $this->business->reviews_count,
                "bestRating" => 5,
                "worstRating" => 1
            ],
            "reviews" => $this->getReviewsSchema()
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    private function getBusinessSchemaType()
    {
        $category = strtolower($this->business->category->name);
        return match ($category) {
            'restaurant' => 'Restaurant',
            'clinic', 'doctor' => 'MedicalClinic',
            'mechanic' => 'AutoRepair',
            'artist' => 'Person',
            default => 'LocalBusiness'
        };
    }

    private function getReviewsSchema()
    {
        return $this->business->reviews->map(function ($review) {
            return [
                "@type" => "Review",
                "author" => [
                    "@type" => "Person",
                    "name" => $review->reviewer_name
                ],
                "datePublished" => $review->created_at->format('Y-m-d'),
                "reviewBody" => $review->review_text,
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $review->rating,
                    "bestRating" => 5,
                    "worstRating" => 1
                ]
            ];
        })->toArray();
    }
}
