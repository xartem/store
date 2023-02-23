<?php

namespace Database\Factories;

use Domain\Auth\Models\User;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Catalog\Models\Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->company()),
            'slug' => $this->faker->slug(),
            'thumbnail' => $this->faker->fixturesImage('brands', 'images/brands'),
            'is_show_on_main_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
