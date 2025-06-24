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
        $contact_website = $business->contact_website;

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
        $businessInfo .= "website: $contact_website\n";
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

    protected function preparePrompt()
    {
        return "Act as a trusted, unbiased reviews analyst writing for a public-facing business review platform. You are provided the name, category, location, and possibly website of a business or public entity.

                Your task is to:
                1. Search the web for publicly available reviews, articles, or feedback (e.g., Google Reviews, Yelp, TripAdvisor, Reddit, blogs, or forums).
                2. Write a professional, engaging, and honest summary of customer sentiment.
                3. Structure your response clearly using the following sections:
                    - **Overall Sentiment**
                    - **Recurring Themes** (use bullet points)
                    - **Notable Details** (optional: e.g., owner name, unique services, standout features)
                    - **Estimated Rating**: Out of 5, in bold (e.g., **4.6/5**)
                    - **Final Verdict**: One catchy sentence summarizing the experience

                Style Guidelines:
                - Your tone must be neutral but reader-friendly and authoritative.
                - Do **not** add introductions like “Let’s dive in…” or “Here’s what I found...”
                - Keep it concise but informative.
                - Avoid fluff or repetition.
                - Emphasize facts and commonly repeated opinions.
                - If no useful data is found, say: “Insufficient public data available to generate a reliable summary..
                    \n\n";
    }

    /**
     * @desc Gather info about the business online and read all reviews if given on any site and generate a summmary of all of
     */

    public function generateExternalBusinessAIReview($businessId)
    {
        $business = Business::find($businessId);
        if (!$business) {
            throw new \Exception('Business not found');
        }
        $businessName = $business->name;
        $businessCategory = $business->category;
        $businessLocation = $business->location;
        $contact_website = $business->contact_website;

        $prompt = "Act as a trusted third-party reviews analyst. You are given the name, category, and location of a business. 
            Your task is to perform a web search and analyze publicly available reviews, comments, and feedback (e.g., Google, Yelp, TripAdvisor, glassdoor, forums, social media, etc.) to:

            - Provide a concise, neutral, and reader-friendly summary of the general customer sentiment.
            - Highlight recurring themes in the available feedback (e.g., quality of service, pricing, staff behavior, atmosphere, delivery speed).
            - Mention any specific details you find, such as the owner's name, special services, or standout moments.
            - Offer an estimated rating out of 5 based on your findings.
            - Conclude with a catchy final verdict in one sentence.

            If no significant information is found online, please say so clearly.

            Your tone should be engaging, professional, and suitable for display on a public business review platform.
            Follow these instructions carefully:
                    1. Do not give an intro or an outro.
                    2. Return the ratings in bold.

            Business Information:
            Name: {$businessName}
            " . ("Category: {$businessCategory}\n") .
            ("Location: {$businessLocation}\n") .
            ("website: {$contact_website}\n") . "

            Start your analysis below:
";

        return $this->geminiService->generateContent($prompt);
    }
}
