<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WriteReviewRequest;
use App\Models\Review;

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
            return redirect()->route('businesses.show', $request->business_id)->with('Message', 'Review submitted successfully!');
        } else {
            return redirect()->route('user.show', $request->user_id)->with('Message', 'Review submitted successfully!');
        }
    }
}
