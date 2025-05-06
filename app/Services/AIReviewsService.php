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

        $prompt = "Act as a trusted third-party reviews analyst. You are given the name, address, and website of a
                    business, followed by the latest customer reviews (each with a rating and comment). Your task is to:

                    Provide a brief, honest, and reader-friendly summary of the overall customer sentiment.

                    Highlight recurring themes (e.g., good service, fast delivery, pricing, etc.).

                    Mention any useful context from the reviews (e.g., owner's name, delivery method, extra services).

                    Give a summary rating out of 5, and a catchy final verdict in one sentence.

                    Your tone should be neutral yet engaging, sounding authoritative but easy to read—ideal for display on a public-facing business review website\n\n";

        $businessInfo = "Business Name: $businessName\n";
        $businessInfo .= "Category: $businessCategory\n";
        $businessInfo .= "Location: $businessLocation\n";
        $businessInfo .= "Average Rating: $averageRating\n\n";

        $prompt .= $businessInfo;

        $latestReviews = $business->reviews()->latest()->take(12)->get();

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
