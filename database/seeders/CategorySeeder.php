<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => Str::slug('Electronics'),
                'parent_id' => null,
                'is_visible' => true,
                'description' => 'Devices, gadgets, and other electronic products.',
            ],
            [
                'name' => 'Laptops',
                'slug' => Str::slug('Laptops'),
                'parent_id' => 1, // Will be linked to "Electronics"
                'is_visible' => true,
                'description' => 'Portable personal computers.',
            ],
            [
                'name' => 'Smartphones',
                'slug' => Str::slug('Smartphones'),
                'parent_id' => 1, // Will be linked to "Electronics"
                'is_visible' => true,
                'description' => 'Mobile devices with advanced computing capabilities.',
            ],
            [
                'name' => 'Furniture',
                'slug' => Str::slug('Furniture'),
                'parent_id' => null,
                'is_visible' => true,
                'description' => 'Home and office furniture.',
            ],
            [
                'name' => 'Office Chairs',
                'slug' => Str::slug('Office Chairs'),
                'parent_id' => 4, // Will be linked to "Furniture"
                'is_visible' => true,
                'description' => 'Ergonomic and standard office seating.',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert(array_merge($category, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
