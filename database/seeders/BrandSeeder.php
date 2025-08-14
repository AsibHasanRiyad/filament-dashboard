<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Apple',
                'slug' => Str::slug('Apple'),
                'url' => 'https://www.apple.com',
                'primary_hex' => '#A2AAAD',
                'is_visible' => true,
                'description' => 'Apple Inc. designs and sells electronics, software, and online services.',
            ],
            [
                'name' => 'Samsung',
                'slug' => Str::slug('Samsung'),
                'url' => 'https://www.samsung.com',
                'primary_hex' => '#1428A0',
                'is_visible' => true,
                'description' => 'Samsung Electronics manufactures a wide range of consumer electronics.',
            ],
            [
                'name' => 'Sony',
                'slug' => Str::slug('Sony'),
                'url' => 'https://www.sony.com',
                'primary_hex' => '#000000',
                'is_visible' => true,
                'description' => 'Sony Corporation is a Japanese multinational conglomerate corporation.',
            ],
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert(array_merge($brand, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
