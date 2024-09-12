<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'reviewer_id' => User::factory(),
            // 'business_id' => Business::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comments' => $this->faker->sentence(10),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'updated_at' => now()
        ];
    }
}
