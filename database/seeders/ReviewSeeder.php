<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Business;
use App\Http\Controllers\ReviewController;
use App\Models\Profession;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $reviewController;

    public function __construct(ReviewController $reviewController)
    {
        $this->reviewController = $reviewController;
    }
    public function run(): void
    {
        // Ensure you have existing users and businesses, or you can create some with factories as needed.

        $users = User::all(); // Fetch all users
        $businesses = Business::all(); // Fetch all businesses

        $reviews = Review::all(); // Fetch all businesses

        $Professions = Profession::all();

        foreach ($users as $user) {
            // Review::factory()->count(21)->create([
            //     'user_id' => $user->id,
            //     'reviewer_id' => $users->random()->id
            // ]);

            // $reviews = $user->reviews;

            // foreach ($reviews as $review) {
            //     $this->reviewController->updatingCounting($user, $review->rating);
            // }

            // $user->update([
            //     'profession_id' => $Professions->random()->id
            // ]);
        }
    }
}
