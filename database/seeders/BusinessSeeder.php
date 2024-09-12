<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all(); // Fetch all users

        foreach ($users as $user) {
            Business::factory()->count(3)->create([
                'userId' => $user->id,
            ]);
        }
    }
}
