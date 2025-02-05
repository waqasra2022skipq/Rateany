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

    public function render()
    {
        // / Get the last 6 reviews, sorted by the most recent.
        $reviews = Review::with(['reviewer', 'user', 'business'])->latest()->take(6)->get();

        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });

        return view('livewire.home', compact('reviews', 'categories'));
    }

    public function updateCategory($id)
    {
        // $this->category = Category::find($id);
        $this->dispatch('updateCategory', $id);
    }
}
