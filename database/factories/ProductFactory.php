<?php

namespace Database\Factories;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
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
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(3, true)),
            'slug' => $this->faker->slug(),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'price' => $this->faker->randomNumber(4),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products'),
            'is_show_on_main_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
