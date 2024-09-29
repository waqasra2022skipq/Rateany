<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\BusinessCreateRequest;
use App\Models\Profession;
use Illuminate\Support\Facades\Auth as FacadesAuth;


class BusinessController extends Controller
{
    public function home()
    {
        // / Get the last 20 reviews, sorted by the most recent.
        $reviews = Review::with(['reviewer', 'user', 'business'])->latest()->take(20)->get();

        $topRestaurants = Business::with(['owner'])
            ->where('categoryId', 1)
            ->orderBy('average_rating', 'desc')
            ->limit(8)
            ->get();

        $topGyms = Business::with(['owner'])
            ->where('categoryId', 4)
            ->orderBy('average_rating', 'desc')
            ->limit(8)
            ->get();


        $topMechanics = User::where('profession_id', 7)
            ->orderBy('average_rating', 'desc')
            ->limit(8)
            ->get();

        $categories = Category::all();
        $professions = Profession::all();

        return view('home', compact('reviews', 'topRestaurants', 'topGyms', 'topMechanics', 'categories', 'professions'));
    }
    public function create()
    {
        if (!auth()->check()) {
            return view('user.login');
        }
        $categories = Category::all();
        return view("business.create", [
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $business = Business::with(['owner', 'category'])->where('name', $id)->first();
        $reviews = $business->reviews()->with('reviewer')->paginate(5); // Paginate reviews (5 per page)

        return view('business.show', compact('business', 'reviews'));
    }
    public function allBusinesses(Request $request)
    {
        $userId = null;
        if (FacadesAuth::check()) {
            $userId = request()->user()->id;
        }
        // Get categoryId from query, if not present, it will be null
        $category = $request->query('category');

        // Get search from query, if not present, it will be null
        $search = $request->query('search');

        // Get location from query, if not present, it will be null
        $location = $request->query('location');

        // Start building the query
        $query = Business::with(['owner', 'category']);

        if ($userId) {
            $query->whereNot('userId', $userId);
        }

        // If categoryId exists in the query, apply the filter
        if ($category) {
            $category = Category::where('name', $category)->first();
            $query->where('categoryId', $category->id);
        }

        // If search exists in the query, apply the filter
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // If search exists in the query, apply the filter
        if ($location) {
            $query->where('location', 'LIKE', "%{$location}%");
        }

        // Order by average_rating and paginate the results
        $businesses = $query->orderBy('average_rating', 'desc')->paginate(8);

        $categories = Category::all();

        return view('business.index', ['businesses' => $businesses, 'categories' => $categories]);
    }

    public function myBusinesses()
    {
        try {
            $businesses = Business::with(['owner', 'category'])
                ->where('userId', request()->user()->id)
                ->get();
            return view('business.manage', ['businesses' => $businesses]);
            // return $this->apiSuccess('success', $businesses, 200);
        } catch (\Throwable $th) {
            return $this->apiError('error', $th->getMessage(), 500);
        }
    }

    public function createBusiness(BusinessCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('business_logo')) {
                $imagePath = $request->file('business_logo')->store('business_logos', 'public');
                $validatedData['business_logo'] = $imagePath;
            }
            Business::create($validatedData);

            $businesses = $request->user()->businesses;
            // return $this->apiSuccess("New Business Created", $business, 201);
            return view('business.manage', ['businesses' => $businesses]);
        } catch (\Throwable $th) {
            return $this->apiError('error', $th->getMessage(), 500);
        }
    }

    public function edit($id)
    {
        $business = Business::find($id);
        $categories = Category::all();
        return view("business.edit", [
            'categories' => $categories,
            'business' => $business
        ]);
    }

    public function updateBusiness(BusinessCreateRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $business = Business::find($id);

            if ($request->hasFile('business_logo')) {
                // Delete old profile picture if exists
                if ($business->business_logo && \Storage::exists('public/' . $business->business_logo)) {
                    \Storage::delete('public/' . $business->business_logo);
                }
                $imagePath = $request->file('business_logo')->store('business_logos', 'public');
                $validatedData['business_logo'] = $imagePath;
            }

            $business->update($validatedData);
            // return $this->apiSuccess("New Business Created", $business, 201);

            $user = $request->user();
            return redirect()->route('profile.show', $user->id)->with('Message', 'Business Deleted successfully.');

            // return $this->apiSuccess("New Business Created", $business, 201);
        } catch (\Throwable $th) {
            return $this->apiError('error', $th->getMessage(), 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        Business::destroy($id);
        $user = $request->user();
        return redirect()->back()->with('Message', 'Business Deleted successfully.');
    }


    public function reviewForm($id)
    {
        if (!auth()->check()) {
            return view('user.login');
        }
        return view('components.write-review', [
            'business_id' => $id,
            'user' => ''
        ]);
    }
}
