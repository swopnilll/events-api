<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the categories you want to seed
        $categories = [
            [
                'title' => 'Technology',
                'description' => 'Events related to the latest tech trends and innovations.',
            ],
            [
                'title' => 'Education',
                'description' => 'Seminars, workshops, and other educational events.',
            ],
            [
                'title' => 'Health & Wellness',
                'description' => 'Events promoting health, fitness, and well-being.',
            ],
            [
                'title' => 'Music',
                'description' => 'Concerts, festivals, and other music-related events.',
            ],
            [
                'title' => 'Art & Culture',
                'description' => 'Events showcasing art, theater, and cultural activities.',
            ],
        ];

        // Insert the categories into the database
        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}
