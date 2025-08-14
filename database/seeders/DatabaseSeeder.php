<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Riyad',
            'email' => 'riyad@test.com',
            'password' => Hash::make('123123123'),
        ]);

        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
