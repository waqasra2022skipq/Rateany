<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $username = Str::slug($model->name, '-');

    //         // Check if the slug exists in the database
    //         $existingSlugCount = static::where('username', 'like', $username . '%')->count();

    //         // If the username exists, append a number to make it unique
    //         if ($existingSlugCount > 0) {
    //             $username = $username . '-' . ($existingSlugCount + 1);
    //         }

    //         $model->username = $username;
    //     });
    // }

    public function businesses()
    {
        return $this->hasMany(Business::class, 'categoryId');
    }
}
