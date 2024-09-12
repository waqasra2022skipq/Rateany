<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'business_id', 'reviewer_id', 'rating', 'comments'];

    // Review written for a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Review written for a business
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    // Review written by a user
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
