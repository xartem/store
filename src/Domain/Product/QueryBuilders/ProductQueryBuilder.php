<?php

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Models\Category;
use Domain\Product\Actions\GetViewedProductIdsAction;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{
    public function mainPage(): self
    {
        return $this->select(['id', 'title', 'slug', 'price', 'thumbnail', 'json_properties'])
            ->where('is_show_on_main_page', true)
            ->orderBy('sorting');
    }

    public function catalogPage(): self
    {
        return $this->select(['id', 'title', 'slug', 'price', 'thumbnail', 'json_properties']);
    }

    public function whereCategory(?Category $category = null): self
    {
        return $this->when($category->exists, function (Builder $q) use ($category) {
            $q->whereRelation('categories', 'categories.id', '=', $category->id);
        });
    }

    public function search(?string $search = null): self
    {
        return $this->when($search, function ($q) use ($search) {
            return $q->whereFullText(['title', 'description'], $search);
        });
    }

    public function sorted(): self
    {
        sorter()->apply($this);

        return $this;
    }

    public function filtered(): self
    {
        // foreach (filters() as $filter) {
        //     $q = $filter->apply($q);
        // }

        app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();

        return $this;
    }

    public function views(?Product $product = null): self
    {
        return $this->whereIn('id', app(GetViewedProductIdsAction::class)->run())
            ->when($product, fn ($q) => $q->whereNot('id', $product->id));
    }
}
