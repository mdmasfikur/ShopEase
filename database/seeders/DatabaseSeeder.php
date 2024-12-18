<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a admin user
        $user = User::firstOrCreate(
            [
                'email' => "admin@example.com"
            ],
            [
                'name' => "Administrator",
                'password' => Hash::make('123456789'),
                'is_admin' => true
            ]
        );

        // Create Fake Categories
        $this->call(CategorySeeder::class);

        // Create Fake Products
        Product::factory()->count(20)->create();
    }
}
