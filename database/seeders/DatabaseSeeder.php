<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
            ]
        );

        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'product_name' => 'Produk ' . Str::random(5),
                'image' => 'https://via.placeholder.com/150',
                'price' => rand(10000, 1000000),
                'category' => 'Game',
                'developer' => 'Dev ' . rand(1, 10),
                'created_at' => now()->subMonths(rand(0, 11))->subDays(rand(0, 28)),
                'updated_at' => now(),
            ]);
        }
    }
}
