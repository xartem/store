<?php

namespace Tests\Feature\Product\Jobs;

use Domain\Product\Jobs\MakeProductJsonPropertiesJob;
use Domain\Product\Models\Product;
use Domain\Product\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MakeProductJsonPropertiesJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_json_properties_success()
    {
        $queue = Queue::getFacadeRoot();

        Queue::fake([MakeProductJsonPropertiesJob::class]);

        $properties = Property::factory(10)->create();
        $product = Product::factory()->hasAttached($properties, function () {
            return ['value' => fake()->word()];
        })->create();

        $this->assertEmpty($product->json_properties);

        Queue::swap($queue);

        MakeProductJsonPropertiesJob::dispatchSync($product);

        $product->refresh();

        $this->assertNotEmpty($product->json_properties);
    }
}
