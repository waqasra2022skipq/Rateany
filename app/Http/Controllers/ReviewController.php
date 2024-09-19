<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WriteReviewRequest;
use App\Models\Review;
use App\Models\Business;
use App\Models\User;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'business_id' => 'nullable|exists:businesses,id',
        ]);

        Review::create([
            'user_id' => $request->user_id,
            'business_id' => $request->business_id,
            'reviewer_id' => $request->user()->id,
            'rating' => $request->rating,
            'comments' => $request->comment,
        ]);

        if ($request->business_id) {
            $this->updatingCounting($request->business_id, $request->rating, 'business');
            return redirect()->route('businesses.show', $request->business_id)->with('Message', 'Review submitted successfully!');
        } else {
            $this->updatingCounting($request->user_id, $request->rating, 'user');

            return redirect()->route('user.show', $request->user_id)->with('Message', 'Review submitted successfully!');
        }
    }

    public function updatingCounting($id, $ratings, $type)
    {
        if ($type == 'business') {
            $collection = Business::find($id);
        } else {
            $collection = User::find($id);
        }

        $star_column = "{$ratings}_star_count";
        $collection->increment('reviews_count');
        $collection->increment($star_column);

        // Recalculate the average rating
        $total_rating = (
            1 * $collection->{'1_star_count'} +
            2 * $collection->{'2_star_count'} +
            3 * $collection->{'3_star_count'} +
            4 * $collection->{'4_star_count'} +
            5 * $collection->{'5_star_count'}
        );
        $average_rating = $total_rating / $collection->reviews_count;
        $collection->average_rating = $average_rating;
        $collection->save();
    }
}
