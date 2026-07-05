<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Radio', 'Laptop', 'Satellite', 'Generator', 'Fiber Cable']),
            'serial_number' => strtoupper(fake()->bothify('SNR-####')),
            'status' => fake()->randomElement(['In-Warehouse', 'Deployed', 'Under Repair']),
            'quantity' => fake()->numberBetween(1, 20),
            'category_id' => Category::factory(),
        ];
    }
}
