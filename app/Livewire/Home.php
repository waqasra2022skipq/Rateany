<?php

namespace App\Livewire;

use App\Services\BusinessService;
use App\Services\UserService;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use App\Models\Profession;
use App\Models\Review;
use Livewire\Component;

class Home extends Component
{

    protected UserService $userService;
    protected BusinessService $businessService;

    public function mount(UserService $userService, BusinessService $businessService)
    {
        $this->userService = $userService;
        $this->businessService = $businessService;
    }
    public function render()
    {
        // / Get the last 6 reviews, sorted by the most recent.
        $reviews = Review::with(['reviewer', 'user', 'business'])->latest()->take(6)->get();

        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });
        $professions = Cache::remember('professions', 60 * 60, function () {
            return Profession::all();
        });

        $topBusinesses = $this->businessService->getTopBusinesses();
        $topProfessionals = $this->userService->getTopProfessionals();

        return view('livewire.home', compact('reviews', 'topBusinesses', 'topProfessionals', 'categories', 'professions'));
    }
}
