<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Business extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'categoryId', 'name', 'description', 'location', 'business_logo'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name, '-');
            $slug = Str::slug($model->name, '-');

            // Check if the slug exists in the database
            $existingSlugCount = static::where('slug', 'like', $slug . '%')->count();

            // If the slug exists, append a number to make it unique
            if ($existingSlugCount > 0) {
                $slug = $slug . '-' . ($existingSlugCount + 1);
            }

            $model->slug = $slug;
        });
    }

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

    public function scopeFilter($query, $filters)
    {
        // Filter by userId if provided
        if (isset($filters['userId'])) {
            $query->whereNot('userId', $filters['userId']);
        }

        // Filter by category if provided
        if (isset($filters['category'])) {
            $category = Category::where('slug', $filters['category'])->first();
            if ($category) {
                $query->where('categoryId', $category->id);
            }
        }

        // Filter by search term if provided
        if (isset($filters['search'])) {
            $query->where('name', 'LIKE', "%{$filters['search']}%");
        }

        // Filter by location if provided
        if (isset($filters['location'])) {
            $query->where('location', 'LIKE', "%{$filters['location']}%");
        }

        return $query;
    }
}
