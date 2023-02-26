<?php

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Product\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(3, true)),
            'description' => $this->faker->paragraph(3),
            'slug' => $this->faker->slug(),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'price' => $this->faker->randomNumber(4),
            'thumbnail' => $this->faker->fixturesImage('products', 'products'),
            'is_show_on_main_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
