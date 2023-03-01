<?php

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

class OptionValueCollection extends Collection
{
    public function groupByOptionTitle(): self
    {
        return $this->groupBy(
            fn ($option_value) => $option_value->option->title
        );
    }
}
