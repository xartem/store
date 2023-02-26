<?php

namespace Tests\Feature\App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_success()
    {
        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');

        config()->set(['thumbnail.allowed_sizes' => [$size]]);

        $product = Product::factory()->create();

        $this->get($product->makeThumbnail($size, $method))
            ->assertOk();

        $storage->assertExists(
            "products/$method/$size/".File::basename($product->thumbnail)
        );
    }
}
