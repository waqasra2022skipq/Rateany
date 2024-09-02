<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $businessCategories = [
            'Restaurant',
            'Café',
            'Bar',
            'Gym',
            'Salon',
            'Auto Repair Shop',
            'Grocery Store',
            'Bookstore',
            'Clothing Store',
            'Pharmacy',
            'Supermarket',
            'Furniture Store',
            'Electronics Store',
            'Bakery',
            'Hotel',
            'Motel',
            'Bed and Breakfast',
            'Daycare Center',
            'Pet Store',
            'Veterinary Clinic',
            'Spa',
            'Tattoo Parlor',
            'Movie Theater',
            'Art Gallery',
            'Music Store',
            'Dance Studio',
            'Yoga Studio',
            'Laundry Service',
            'Dry Cleaner',
            'Flower Shop',
            'Photography Studio',
            'Travel Agency',
            'Car Dealership',
            'Bike Shop',
            'Jewelry Store',
            'Hardware Store',
            'Toy Store',
            'Pet Grooming Salon',
            'Car Wash',
            'Gas Station',
            'Home Improvement Store',
            'Real Estate Agency',
        ];


        foreach ($businessCategories as $cat) {
            DB::table('categories')->insert(
                [
                    'name' => $cat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
