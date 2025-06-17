<?php

namespace App\Livewire\Businesses;

use Livewire\Component;
use App\Models\Business;
use App\Models\Review;
use Livewire\WithPagination;
// use App\Services\CaptchaService;
use Illuminate\Support\Facades\Auth;
use App\Services\AIReviewsService;

class BusinessPage extends Component
{
    use WithPagination;

    private AIReviewsService $aiReviewsService;
    public function boot(AIReviewsService $aiReviewsService)
    {
        $this->aiReviewsService = new $aiReviewsService;
    }

    public $business;
    public $activeTab = 'reviews'; // Default active tab
    public $sortBy = 'newest'; // Default sorting
    public $pageTitle;
    public $metaDescription;
    public $totalReviews;
    public $averageRating;

    // Review Form Fields
    public $rating = 1;
    public $comment = '';
    public $reviewer_name = '';
    public $reviewer_email = '';
    public $reviewer_id;
    public $aiSummary = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
        'reviewer_id' => 'nullable|exists:users,id',
        'reviewer_name' => 'required_if:reviewer_id,null|string|max:255',
        'reviewer_email' => 'required_if:reviewer_id,null|email|max:255',
    ];

    public function mount($slug)
    {

        // Fetch business data

        $this->business = Business::where('slug', $slug)->first();
        $this->totalReviews = $this->business->reviews_count;
        $this->averageRating = $this->business->average_rating;

        $this->pageTitle = $this->business->name . " Reviews and Ratings - rated $this->averageRating out of 5, $this->totalReviews reviews";
        $this->metaDescription = $this->business->description;
        $this->reviewer_id = Auth::id();

        $this->aiSummary = $this->business->aiSummary?->ai_summary;
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
            ['pageTitle' => $this->pageTitle, 'metaDescription' => $this->metaDescription, 'schemaMarkup' =>  $schemaMarkup, 'ogImage' => $this->business->business_logo]
        );
    }

    protected function getRatingBreakdown()
    {
        // Calculate rating breakdown (1-5 stars)
        $totalReviews = $this->totalReviews;
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
            "@type" => "LocalBusiness",
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
                "ratingValue" => round($this->averageRating, 1),
                "ratingCount" => $this->business->reviews_count,
                "bestRating" => 5,
                "worstRating" => 1
            ],
            "review" => $this->getReviewsSchema()
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
                "reviewBody" => $review->comments,
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $review->rating,
                    "bestRating" => 5,
                    "worstRating" => 1
                ]
            ];
        })->toArray();
    }

    public function submitReview()
    {
        // Validate the form
        $this->validate();

        // // Verify CAPTCHA for guest users
        // if (!Auth::check()) {
        //     $captchaService = new CaptchaService();
        //     $captchaResult = $captchaService->verifyCaptcha($data);

        //     if (isset($captchaResult['error'])) {
        //         $this->addError('recaptcha', $captchaResult['captchaErrorMessage']);
        //         return;
        //     }
        // }

        // Create the review
        Review::create([
            'business_id' => $this->business->id,
            'reviewer_id' => Auth::id(),
            'reviewer_name' => Auth::check() ? Auth::user()->name : $this->reviewer_name,
            'reviewer_email' => Auth::check() ? Auth::user()->email : $this->reviewer_email,
            'rating' => $this->rating,
            'comments' => $this->comment,
        ]);

        $this->updatingCounting($this->business, $this->rating);

        // Reset the form
        $this->reset(['rating', 'comment', 'reviewer_name', 'reviewer_email']);

        // Switch to the reviews tab
        $this->switchTab('reviews');

        // Show success message
        session()->flash('message', 'Review submitted successfully!');
    }

    private function updatingCounting($business, $ratings)
    {
        $star_column = "{$ratings}_star_count";
        $business->increment('reviews_count');
        $business->increment($star_column);

        // Recalculate the average rating
        $total_rating = (
            1 * $business->{'1_star_count'} +
            2 * $business->{'2_star_count'} +
            3 * $business->{'3_star_count'} +
            4 * $business->{'4_star_count'} +
            5 * $business->{'5_star_count'}
        );
        $average_rating = $total_rating / $business->reviews_count;
        $business->average_rating = $average_rating;
        $business->save();

        $this->totalReviews = $business->reviews_count;
        $this->averageRating = $average_rating;
    }

    public function generateAiSummary()
    {
        $aiSummary = $this->aiReviewsService->generateBusinessAIReview($this->business->id);

        // Save the AI-generated summary to the database
        $this->aiReviewsService->saveAIReview($this->business->id, $aiSummary);

        // Update the local variable
        $this->aiSummary = $aiSummary;

        // Show success message
        session()->flash('message', 'AI summary generated successfully!');
    }
}
