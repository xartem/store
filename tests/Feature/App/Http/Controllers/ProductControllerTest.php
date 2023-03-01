<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\ProductController;
use Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_response_success()
    {
        $product = Product::factory()->create();

        $this->get(action(ProductController::class, $product))
            ->assertViewIs('product.show')
            ->assertViewHas('product', $product)
            ->assertOk();
    }
}
