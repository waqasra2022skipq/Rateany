<?php

namespace App\Services;

use App\Services\GeminiService;
use App\Models\Business;


class AIReviewsService
{
    protected $geminiService;

    public function __construct()
    {
        $this->geminiService = new GeminiService();
    }

    public function generateBusinessAIReview($businessId)
    {
        $business = Business::find($businessId);
        if (!$business) {
            throw new \Exception('Business not found');
        }
        $businessName = $business->name;
        $businessCategory = $business->category;
        $businessLocation = $business->location;
        $averageRating = $business->average_rating;

        $prompt = "Think of yourself as a authenticated authority to rate a business/product/professional based on real customers/users reviews. You will be provided with complete info and some latest reviews from customers and you need to generate an honest summary\n\n";

        $businessInfo = "Business Name: $businessName\n";
        $businessInfo .= "Category: $businessCategory\n";
        $businessInfo .= "Location: $businessLocation\n";
        $businessInfo .= "Average Rating: $averageRating\n\n";

        $prompt .= $businessInfo;

        $latestReviews = $business->reviews()->latest()->take(5)->get();

        $prompt .= "Latest Reviews:\n";
        foreach ($latestReviews as $review) {
            $prompt .= "Rating: {$review->rating}\n";
            $prompt .= "Comment: {$review->comment}\n";
        }
        $prompt .= "\n\n";

        return $this->geminiService->generateContent($prompt);
    }
    public function saveAIReview($businessId, $aiSummary)
    {
        $business = Business::find($businessId);
        $business->aiSummary()->updateOrCreate(
            ['business_id' => $businessId],
            ['ai_summary' => $aiSummary]
        );
    }
}
