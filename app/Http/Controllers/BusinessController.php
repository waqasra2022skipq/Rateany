<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\BusinessCreateRequest;

class BusinessController extends Controller
{
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
        $business = Business::with(['owner', 'category'])->find($id);
        $reviews = $business->reviews()->with('reviewer')->paginate(5); // Paginate reviews (5 per page)

        return view('business.show', compact('business', 'reviews'));
    }
    public function catBusinesses($categoryId)
    {
        $businesses = Business::with(['owner', 'category'])->where('categoryId', $categoryId)->get();
        return view('business.manage', ['businesses' => $businesses]);
    }

    public function index()
    {
        try {
            $businesses = Business::with(['owner', 'category'])->get();
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
