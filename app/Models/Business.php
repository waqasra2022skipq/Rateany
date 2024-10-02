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
}
