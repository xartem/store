<?php

namespace App\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AppRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');
            Route::get('/storage/{directory}/{method}/{size}/{file}', ThumbnailController::class)
                ->name('thumbnail')
                ->where('method', 'resize|crop|fix')
                ->where('size', '\d+x\d+')->where('file', '.+\.(jpg|png|gif)$');
        });
    }
}
