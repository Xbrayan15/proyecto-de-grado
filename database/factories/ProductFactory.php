<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->productName(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'cost' => $this->faker->randomFloat(2, 5, 500),
            'sku' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'code' => $this->faker->unique()->regexify('PRD[0-9]{6}'),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'quantity' => $this->faker->numberBetween(0, 100), // alias for stock_quantity
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'dimensions' => $this->faker->randomElement(['10x10x10', '20x15x5', '30x20x10']),
            'is_active' => $this->faker->boolean(90),
            'category_id' => null, // Can be set if Category factory exists
        ];
    }
}
