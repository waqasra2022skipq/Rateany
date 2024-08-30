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
        $users = User::all();
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
}
