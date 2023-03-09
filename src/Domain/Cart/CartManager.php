<?php

namespace Domain\Cart;

use Domain\Cart\Contract\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Cart\StorageIdentities\FakeSessionIdentityStorage;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObject\Price;

class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $cartIdentityStorage
    ) {
    }

    public static function fake(): void
    {
        app()->bind(CartIdentityStorageContract::class, FakeSessionIdentityStorage::class);
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): CartItem
    {
        $this->forgetCache();

        $cart = Cart::query()->updateOrCreate([
            'storage_id' => $this->cartIdentityStorage->get(),
        ], $this->storeData($this->cartIdentityStorage->get()));

        $cartItem = $cart->cartItems()->updateOrCreate([
            'product_id' => $product->getKey(),
            'string_option_values' => $this->stringedOptionValues($optionValues),
        ], [
            'price' => $product->price,
            'quantity' => DB::raw("quantity + $quantity"),
            'string_option_values' => $this->stringedOptionValues($optionValues),
        ]
        );

        $cartItem->optionValues()->sync($optionValues);

        return $cartItem;
    }

    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity,
        ]);

        $this->forgetCache();
    }

    public function delete(CartItem $item): void
    {
        $item->delete();

        $this->forgetCache();
    }

    public function truncate(): void
    {
        if ($this->get()) {
            $this->get()->delete();
        }

        $this->forgetCache();
    }

    public function items(): Collection
    {
        if (! $this->get()) {
            return collect();
        }

        return $this->get()
            ->cartItems()
            ->with(['product', 'optionValues.option'])
            ->get();
    }

    public function cartItems(): Collection
    {
        if ($this->get()) {
            return $this->get()->cartItems;
        }

        return collect();
    }

    public function count(): int
    {
        return $this->cartItems()->sum('quantity');
    }

    public function amount(): Price
    {
        return Price::make(
            $this->cartItems()->sum(fn ($item) => $item->amount->raw())
        );
    }

    public function get(): bool|Cart
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function () {
            return Cart::query()->with('cartItems')
                ->where('storage_id', $this->cartIdentityStorage->get())
                ->when(auth()->check(), function (Builder $q) {
                    return $q->orWhere('user_id', auth()->id());
                })
                ->first() ?? false;
        });
    }

    public function updateStorageId(string $oldId, string $newId): void
    {
        Cart::query()
            ->where('storage_id', $oldId)
            ->update($this->storeData($newId));
    }

    private function storeData(string $id): array
    {
        $data['storage_id'] = $id;

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function stringedOptionValues($optionValues): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    private function cacheKey(): string
    {
        return str('cart_'.$this->cartIdentityStorage->get())
            ->slug('_')
            ->value();
    }

    private function forgetCache(): bool
    {
        return Cache::forget($this->cacheKey());
    }
}
