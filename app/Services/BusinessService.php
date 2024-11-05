<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class BusinessService
{
    public function getTopBusinesses($limit = 8)
    {
        return Business::selectRaw('*, (average_rating * 0.7) + (reviews_count * 0.3) as smart_score')
            ->orderBy('smart_score', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getAllBusinesses($request)
    {
        $userId = FacadesAuth::id();

        // Collect filters in an array
        $filters = [
            'userId' => $userId,
            'category' => $request->query('category'),
            'search' => $request->query('search'),
            'location' => $request->query('location'),
        ];


        // Get businesses with applied filters and ordered by rating
        $businesses = Business::with(['owner:id,name', 'category:id,name,slug']) // Load only necessary columns
            ->filter($filters)
            ->selectRaw('*, (average_rating * 0.7) + (reviews_count * 0.3) as smart_score')
            ->orderBy('smart_score', 'desc')
            ->paginate(20);

        return $businesses;
    }
}
