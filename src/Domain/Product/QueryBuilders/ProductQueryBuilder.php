<?php

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{
    public function mainPage(): self
    {
        return $this->where('is_show_on_main_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function catalogPage(?Category $category = null)
    {
        return $this->select(['id', 'title', 'slug', 'price', 'thumbnail'])
            ->when($category->exists, function (Builder $q) use ($category) {
                $q->whereRelation('categories', 'categories.id', '=', $category->id);
            })
            ->when(request('s'), function ($q) {
                return $q->whereFullText(['title', 'description'], request('s'));
            })
            ->filtered()
            ->sorted();
    }

    public function sorted(): self
    {
        // foreach (sorts() as $sort) {
        //     $sort->apply($this);
        // }

        app(Pipeline::class)
            ->send($this)
            ->through(sorts())
            ->thenReturn();

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
}
