<?php

namespace App\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\CartController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class CartRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(CartController::class)->prefix('cart')->group(function () {
                Route::get('/', 'index')->name('cart');
                Route::post('/{product}/add', 'add')->name('cart.add');
                Route::post('/{cart_item}/quantity', 'quantity')->name('cart.quantity');
                Route::delete('/{cart_item}/delete', 'delete')->name('cart.delete');
                Route::delete('/truncate', 'truncate')->name('cart.truncate');
            });
        });
    }
}
