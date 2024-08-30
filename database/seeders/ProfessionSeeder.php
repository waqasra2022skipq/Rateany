<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professions = [
            'Doctor',
            'Engineer',
            'Teacher',
            'Artist',
            'Lawyer',
            'Chef',
            'Mechanic',
            'Nurse',
            'Carpenter',
            'Electrician',
            'Plumber',
            'Architect',
            'Accountant',
            'Dentist',
            'Pharmacist',
            'Photographer',
            'Software Developer',
            'Web Designer',
            'Content Writer',
            'Data Scientist',
            'Business Analyst',
            'Project Manager',
            'Marketing Specialist',
            'Salesperson',
            'Consultant',
            'Graphic Designer',
        ];

        foreach ($professions as $profession) {
            DB::table('profession')->insert([
                'name' => $profession,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
