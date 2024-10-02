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

        $currentUserId = $request->user()->id;

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'business_id' => 'nullable|exists:businesses,id',
        ]);
        $type = 'business';

        if ($request->business_id) {
            $collection = Business::find($request->business_id);

            if ($collection->owner->id == $currentUserId) {
                return redirect()->back()->with('Message', 'You cannot rate your own business');
            }
        } else {
            $collection = User::find($request->user_id);
            if ($collection->id == $currentUserId) {
                return redirect()->back()->with('Message', 'You cannot rate yourself');
            }
            $type = 'user';
        }

        Review::create([
            'user_id' => $request->user_id,
            'business_id' => $request->business_id,
            'reviewer_id' => $currentUserId,
            'rating' => $request->rating,
            'comments' => $request->comment,
        ]);
        $this->updatingCounting($collection, $request->rating);

        if ('business' == $type) {
            return redirect()->route('businesses.show', $collection->slug)->with('Message', 'Review submitted successfully!');
        } else {
            return redirect()->route('user.show', $collection->username)->with('Message', 'Review submitted successfully!');
        }
    }

    public function updatingCounting($collection, $ratings)
    {
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
