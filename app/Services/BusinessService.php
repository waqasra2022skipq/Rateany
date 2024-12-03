<?php

namespace App\Services;

use App\Models\Business;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class BusinessService
{
    public function getTopBusinesses($limit = 8)
    {
        return Business::withSmartScore()
            ->has('reviews') // Only include businesses with reviews
            ->orderBy('smart_score', 'desc')
            ->with(['owner:id,name', 'category:id,name,slug'])
            ->limit($limit)
            ->get();
    }

    public function getAllBusinesses($request)
    {
        $filters = $this->prepareFilters($request);
        
        return Business::withSmartScore()
            ->with(['owner:id,name', 'category:id,name,slug'])
            ->filter($filters)
            ->orderBy('smart_score', 'desc')
            ->paginate(20);
    }

    private function prepareFilters($request)
    {
        return [
            'userId' => auth()->id(),
            'category' => $request->query('category'),
            'search' => $request->query('search'),
            'location' => $request->query('location'),
        ];
    }
}
