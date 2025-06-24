<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Business;
use App\Services\ReviewService;
use App\Services\AIReviewsService;

class GenerateAIReview extends Component
{
    public $business_name;
    public $business_category;
    public $business_location;
    public $contact_website;

    public $generating = false;
    public $latestAIReviews = [];

    protected $rules = [
        'business_name' => 'required|string|max:255',
        'business_category' => 'required|string|max:100',
        'business_location' => 'nullable|string|max:255',
        'contact_website' => 'nullable|url|max:255',
    ];

    private AIReviewsService $aiReviewsService;
    public function boot(AIReviewsService $aiReviewsService)
    {
        $this->aiReviewsService = new $aiReviewsService;
        $this->latestAIReviews = \App\Models\AISummary::with('business')->latest()->take(10)->get();
    }

    public function render()
    {
        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        return view('livewire.generate-ai-review', [
            'categories' => $categories,
            'latestAIReviews' => $this->latestAIReviews,
        ])->layout('components.layouts.app', [
            'metaDescription' => "Generate AI review for any business, product, or service using RateAny's AI Review Generator.",
            'pageTitle' => "Generate AI Review for Business - " . config('app.name'),
        ]);
    }

    public function generateAIReview()
    {
        $this->validate();

        $business_category = $this->validateBusinessCategory();
        $business = $this->validateBusiness($business_category);

        $aiSummary = $this->aiReviewsService->generateExternalBusinessAIReview($business->id);

        // Save the AI-generated summary to the database
        $this->aiReviewsService->saveAIReview($business->id, $aiSummary);

        return redirect()->route('businesses.show', $business->slug);
    }

    public function validateBusiness($business_category)
    {
        // Check if the business already exists
        $business = Business::where('name', $this->business_name)
            ->where('location', $this->business_location)
            ->first();

        // If the business doesn't exist, create it
        if (!$business) {
            $business = Business::create([
                'name' => $this->business_name,
                'userId' => 1167,
                'categoryId' => $business_category->id,
                'location' => $this->business_location,
                'contact_website' => $this->contact_website,
            ]);
        }

        return $business;
    }
    public function validateBusinessCategory()
    {
        $business_category = Category::where('name', $this->business_category)->first();
        if (!$business_category) {
            $business_category = Category::create([
                'name' => $this->business_category,
                'slug' => \Str::slug($this->business_category),
            ]);
        }
        return $business_category;
    }
}
