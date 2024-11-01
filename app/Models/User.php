<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profession_id',
        'profile_pic',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $username = Str::slug($model->name, '-');

            // Check if the slug exists in the database
            $existingSlugCount = static::where('username', 'like', $username . '%')->count();

            // If the username exists, append a number to make it unique
            if ($existingSlugCount > 0) {
                $username = $username . '-' . ($existingSlugCount + 1);
            }

            $model->username = $username;
        });
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class, 'userId');
    }

    // Reviews written by this user
    public function writtenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    // Reviews about this user
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeFilter($query, $filters)
    {
        // Exclude specific user if provided
        if (isset($filters['userId'])) {
            $query->whereNot('id', $filters['userId']);
        }

        // Filter by profession if provided
        if (isset($filters['profession'])) {
            $profession = Profession::where('slug', $filters['profession'])->first();
            if ($profession) {
                $query->where('profession_id', $profession->id);
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
