<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Gumawa o hanapin ang default user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Magpasok ng sample menu items para sa POS
        $menuItems = [
            ['name' => 'Burger', 'price' => 99.00],
            ['name' => 'Fries', 'price' => 49.00],
            ['name' => 'Iced Tea', 'price' => 29.00],
            ['name' => 'Fried Chicken', 'price' => 120.00],
            ['name' => 'Spaghetti', 'price' => 89.00],
        ];

        foreach ($menuItems as $item) {
            MenuItem::firstOrCreate(
                ['name' => $item['name']],
                ['price' => $item['price']]
            );
        }
    }
}