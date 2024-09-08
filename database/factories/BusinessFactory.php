<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business>
 */
class BusinessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'userId' => \App\Models\User::factory(),
            'name' => $this->faker->company(),
            'categoryId' => \App\Models\Category::inRandomOrder()->first()->id,
            'location' => $this->faker->address,
            'description' => $this->faker->paragraph()
        ];
    }
}
