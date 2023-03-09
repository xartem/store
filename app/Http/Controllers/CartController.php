<?php

namespace App\Http\Controllers;

use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('cart.index', [
            'items' => cart()->items(),
        ]);
    }

    public function add(Product $product): RedirectResponse
    {
        cart()->add($product, request('quantity', 1), request('options', []));

        flash()->info('Товар добавлен в корзину');

        return redirect()->intended(route('cart'));
    }

    public function quantity(CartItem $cartItem): RedirectResponse
    {
        cart()->quantity($cartItem, request('quantity', 1));

        flash()->info('Кол-во товаров изменено');

        return redirect()->intended(route('cart'));
    }

    public function delete(CartItem $cartItem): RedirectResponse
    {
        cart()->delete($cartItem);

        flash()->info('Удалено из корзины');

        return redirect()->intended(route('cart'));
    }

    public function truncate(): RedirectResponse
    {
        cart()->truncate();

        flash()->info('Корзина очищена');

        return redirect()->intended(route('cart'));
    }
}
