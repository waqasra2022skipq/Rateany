<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profession;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}
    public function getAllUsers()
    {
        $users = User::with('profession', 'businesses')->get();
        return $users;
    }

    public function createUser(array $userData): User
    {
        $profession = '';

        if (isset($userData['profession_id'])) {
            $profession = Profession::find($userData['profession_id']);
        }
        $user = User::create($userData);
        if ($user && $profession) {
            $profession->update([
                'count' => $profession->count + 1
            ]);
        }
        return $user;
    }

    public function getTopProfessionals($limit = 20)
    {
        return User::whereNotNull('profession_id')
            ->selectRaw('*, (average_rating * 0.7) + (reviews_count * 0.3) as smart_score')
            ->orderBy('smart_score', 'desc')
            ->limit($limit)
            ->get();
    }
}
