<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Requests\BusinessCreateRequest;
use App\Models\Profession;
use App\Services\BusinessService;
use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;



class BusinessController extends Controller
{
    protected $businessService;
    protected $userService;

    public function __construct()
    {
        $this->businessService = new BusinessService();
        $this->userService = new UserService();
    }
    public function home()
    {
        // / Get the last 20 reviews, sorted by the most recent.
        $reviews = Review::with(['reviewer', 'user', 'business'])->latest()->take(20)->get();

        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });
        $professions = Cache::remember('professions', 60 * 60, function () {
            return Profession::all();
        });

        $topBusinesses = $this->businessService->getTopBusinesses();
        $topProfessionals = $this->userService->getTopProfessionals();

        return view('home', compact('reviews', 'topBusinesses', 'topProfessionals', 'categories', 'professions'));
    }
    public function create()
    {
        if (!auth()->check()) {
            return view('user.login');
        }
        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });
        return view("business.create", [
            'categories' => $categories
        ]);
    }

    public function show($slug)
    {
        $business = Business::with(['owner', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();
            
        $reviews = $business->reviews()
            ->latest()
            ->with('reviewer')
            ->paginate(5);
            
        return view('business.show', [
            'business' => $business,
            'reviews' => $reviews,
            'metaDescription' => $business->description,
            'pageTitle' => $business->name
        ]);
    }
    public function allBusinesses(Request $request)
    {
        $businesses = $this->businessService->getAllBusinesses($request);
        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });

        $topMessage = "Businesses";
        if (!empty($request->category)) {
            $topMessage = ucfirst(Str::plural(str_replace('-', ' ', $request->category)));
        }

        if (!empty($request->location)) {
            $topMessage .= " in " . $request->location;
        }
        return view('business.index', ['businesses' => $businesses, 'categories' => $categories, "topMessage" => $topMessage]);
    }

    public function myBusinesses()
    {
        try {
            $businesses = Business::with(['category'])
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
                $validatedData['business_logo'] = $this->handleLogoUpload($request->file('business_logo'));
            }
            
            $business = Business::create($validatedData);
            
            return redirect()
                ->route('businesses.manage')
                ->with('Message', 'Business created successfully');
                
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to create business')
                ->withInput();
        }
    }

    private function handleLogoUpload($file)
    {
        return $file->store('business_logos', 'public');
    }

    public function edit($id)
    {
        $business = Business::find($id);
        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });
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
            return redirect()->route('profile.show', $user->id)->with('Message', 'Business Updated successfully.');

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
