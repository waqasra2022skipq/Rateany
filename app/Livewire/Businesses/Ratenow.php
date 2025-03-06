<?php

namespace App\Livewire\Businesses;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Services\ReviewService;

use Livewire\Component;

class Ratenow extends Component
{

    // Review Form Fields
    public $rating = 1;
    public $comment = '';
    public $reviewer_name = '';
    public $reviewer_email = '';
    public $reviewer_id;

    public $business_name;
    public $business_category;
    public $business_location;
    public $contact_phone;

    protected $rules = [
        'business_name' => 'required|string|max:255',
        'business_category' => 'required|string|max:20',
        'business_location' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|max:1000',
        'reviewer_id' => 'nullable|exists:users,id',
        'reviewer_name' => 'required_if:reviewer_id,null|string|max:255',
        'reviewer_email' => 'required_if:reviewer_id,null|email|max:255',
        'contact_phone' => ['nullable', 'string', 'max:20'],
    ];

    public function mount()
    {
        $this->reviewer_id = Auth::id();
        $this->reviewer_email = Auth::check() ? Auth::user()->email : '';
        $this->reviewer_name = Auth::check() ? Auth::user()->name : '';
    }

    public function render()
    {
        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });

        return view('livewire.businesses.ratenow', ['categories' => $categories]);
    }

    public function submitReview()
    {
        $this->validate();

        $business_category = $this->validateBusinessCategory();
        $business = $this->validateBusiness($business_category);

        $reviewService = new ReviewService();
        $review = $reviewService->createReview($business, $this->reviewer_id, $this->rating, $this->comment, $this->reviewer_email, $this->reviewer_name);
        $reviewService->updatingCounting($business, $this->rating);

        return redirect()->route('businesses.show', $business->slug);
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
                'contact_phone' => $this->contact_phone,
                'reviews_count' => 0,
                'average_rating' => 0,
                '1_star_count' => 0,
                '2_star_count' => 0,
                '3_star_count' => 0,
                '4_star_count' => 0,
                '5_star_count' => 0,
            ]);
        }

        return $business;
    }
}
