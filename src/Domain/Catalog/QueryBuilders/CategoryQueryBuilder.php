<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{
    public function mainPage(): self
    {
        return $this->select(['id', 'title', 'slug'])
            ->where('is_show_on_main_page', true)
            ->orderBy('sorting')
            ->limit(10);
    }

    public function catalogPage(): self
    {
        return $this->select(['id', 'title', 'slug'])
            ->has('products');
    }
}
