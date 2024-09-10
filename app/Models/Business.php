<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'categoryId', 'name', 'description', 'location', 'business_logo'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'userId');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    // Reviews about this business
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
