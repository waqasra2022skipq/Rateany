<?php

namespace App\Services;

use App\Models\Review;

class ReviewService
{
    public function updatingCounting($business, $ratings)
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

        return $business;
    }

    public function createReview($business, $userId, $rating, $comment, $reviewer_email, $reviewer_name)
    {
        return Review::create([
            'business_id' => $business->id,
            'reviewer_id' => $userId,
            'reviewer_name' => $reviewer_name,
            'reviewer_email' => $reviewer_email,
            'rating' => $rating,
            'comments' => $comment,
        ]);
    }
}
