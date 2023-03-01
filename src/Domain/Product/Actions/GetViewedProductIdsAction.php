<?php

namespace Domain\Product\Actions;

class GetViewedProductIdsAction
{
    public function __invoke(): array
    {
        return $this->run();
    }

    public function run(): array
    {
        return session('product.views', []);
    }
}
