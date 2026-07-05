<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Radios',
            'slug' => 'radios',
            'description' => 'Critical signal equipment for field operations.',
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Standard PC units for command and control centers.',
        ]);

        Category::create([
            'name' => 'Satellites',
            'slug' => 'satellites',
            'description' => 'Support equipment for 24/7 operation.',
        ]);


    }
}
