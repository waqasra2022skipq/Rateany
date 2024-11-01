<?php

namespace App\Services;

use App\Models\Business;

class BusinessService
{
    public function getTopBusinesses($limit = 8)
    {
        return Business::selectRaw('*, (average_rating * 0.7) + (reviews_count * 0.3) as smart_score')
            ->orderBy('smart_score', 'desc')
            ->limit($limit)
            ->get();
    }
}
