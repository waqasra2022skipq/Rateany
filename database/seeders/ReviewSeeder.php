<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Business;


class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure you have existing users and businesses, or you can create some with factories as needed.

        $users = User::all(); // Fetch all users
        $businesses = Business::all(); // Fetch all businesses

        foreach ($users as $user) {
            Review::factory()->count(21)->create([
                'user_id' => $user->id,
                'reviewer_id' => $users->random()->id
            ]);
        }
    }
}
