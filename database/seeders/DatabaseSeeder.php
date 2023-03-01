<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Option;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Domain\Product\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Brand::factory(20)->create();

        $properties = Property::factory(9)->create();

        Option::factory(2)->create();

        $optionValues = OptionValue::factory(10)->create();

        Product::factory(20)
            ->has(Category::factory(rand(1, 2)))
            ->hasAttached($optionValues)
            ->hasAttached($properties, function () {
                return ['value' => ucfirst(fake()->word())];
            })
            ->create();
    }
}
