<?php

namespace Tests\Unit\Support\Cast;

use Domain\Product\Models\Product;
use Support\Casts\PriceCast;
use Support\ValueObject\Price;
use Tests\TestCase;

class PriceCastTest extends TestCase
{
    public function test_all()
    {
        $price_cast = new PriceCast();

        $this->assertInstanceOf(
            Price::class,
            $price_cast->get(new Product, 'price', 10000, []),
        );

        $this->assertEquals(
            10000,
            $price_cast->set(new Product, 'price', 10000, []),
        );
    }
}
