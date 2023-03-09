<?php

namespace Tests\Feature\App\Http\Controllers;

use Domain\Cart\CartManager;
use Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected ?Product $product = null;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();

        $this->product = Product::factory()->create();
    }

    public function test_is_empty_cart()
    {
        $this->get(route('cart'))
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect())
            ->assertOk();
    }

    public function test_is_not_empty_cart()
    {
        cart()->add($this->product);

        $this->get(route('cart'))
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items())
            ->assertOk();
    }

    public function test_added_to_cart_success()
    {
        $this->assertEquals(0, cart()->count());

        $this->post(route('cart.add', $this->product), ['quantity' => 4])
            ->assertRedirectToRoute('cart');

        $this->assertEquals(4, cart()->count());
    }

    public function test_quantity_update_success()
    {
        $item = cart()->add($this->product, 2);

        $this->assertEquals(2, cart()->count());

        $this->post(route('cart.quantity', $item), ['quantity' => 8])
            ->assertRedirectToRoute('cart');

        $this->assertEquals(8, cart()->count());
    }

    public function test_delete_item_success()
    {
        $item = cart()->add($this->product, 2);

        $this->assertEquals(2, cart()->count());

        $this->delete(route('cart.delete', $item))
            ->assertRedirectToRoute('cart');

        $this->assertEquals(0, cart()->count());
    }

    public function test_truncate_success()
    {
        cart()->add($this->product, 2);

        $this->assertEquals(2, cart()->count());

        $this->delete(route('cart.truncate'))
            ->assertRedirectToRoute('cart');

        $this->assertEquals(0, cart()->count());
    }
}
