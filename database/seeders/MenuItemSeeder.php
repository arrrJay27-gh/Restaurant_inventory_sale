<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        MenuItem::create([
            'name' => 'Milk Tea Classic',
            'price' => 99.00,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Fresh Milk Latte',
            'price' => 120.00,
            'is_active' => true,
        ]);
    }
}
