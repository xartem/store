<?php

namespace Domain\Cart\StorageIdentities;

use Domain\Cart\Contract\CartIdentityStorageContract;

class FakeSessionIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return 'test';
    }
}
