<?php

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class BrandQueryBuilder extends Builder
{
    public function mainPage(): self
    {
        return $this->where('is_show_on_main_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }
}