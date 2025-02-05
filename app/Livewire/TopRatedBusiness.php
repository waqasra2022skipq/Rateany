<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class TopRatedBusiness extends Component
{

    public $category;

    protected $listeners = ['updateCategory'];

    public function render()
    {
        $categories = Cache::remember('categories', 60 * 60, function () {
            return Category::all();
        });

        $topBusinesses = Business::query()
            ->when($this->category, function ($query) {
                $query->where('categoryId', $this->category->id);
            })
            ->withSmartScore()
            ->orderBy('smart_score', 'desc')
            ->limit(6)
            ->get();
        return view('livewire.top-rated-business', compact('categories', 'topBusinesses'));
    }

    public function updateCategory($id)
    {
        $this->category = Category::find($id);
    }
}
