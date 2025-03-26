<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'user_id' => 2, // Sempre será atribuído ao usuário com ID 2
            'brand_id' => Brand::inRandomOrder()->first()->id ?? 1, // Escolhe uma marca aleatória
            'category_id' => Category::inRandomOrder()->first()->id ?? 1, // Escolhe uma categoria aleatória
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
