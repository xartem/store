<?php

namespace Tests\Feature\App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_response_success()
    {
        Product::factory(5)->create([
            'is_show_on_main_page' => true,
            'sorting' => 999,
        ]);

        $product = Product::factory()->create([
            'is_show_on_main_page' => true,
            'sorting' => 1,
        ]);

        Category::factory()->create([
            'is_show_on_main_page' => true,
            'sorting' => 999,
        ]);

        $category = Category::factory()->create([
            'is_show_on_main_page' => true,
            'sorting' => 1,
        ]);

        Brand::factory()->create([
            'is_show_on_main_page' => true,
            'sorting' => 999,
        ]);

        $brand = Brand::factory()->create([
            'is_show_on_main_page' => true,
            'sorting' => 1,
        ]);

        $this->get(route('home'))
            ->assertViewIs('index')
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('products.0', $product)
            ->assertViewHas('brands.0', $brand)
            ->assertOk();
    }
}
