<?php

namespace Domain\Auth\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::prefix('auth')->group(function () {
                Route::middleware('auth')->group(function () {
                    Route::delete('logout', LogoutController::class)->name('logout');
                });
                Route::middleware([])->group(function () {
                    Route::get('login', [LoginController::class, 'page'])->name('login');
                    Route::post('login', [LoginController::class, 'handle'])->name('login.handle');
                    Route::get('register', [RegisterController::class, 'page'])->name('register');
                    Route::post('register', [RegisterController::class, 'handle'])->name('register.handle');
                    Route::get('forgot', [ForgotPasswordController::class, 'page'])->name('forgot');
                    Route::post('forgot', [ForgotPasswordController::class, 'handle'])->name('forgot.handle');
                    Route::get('reset/{token}', [ResetPasswordController::class, 'page'])->name('password.reset');
                    Route::post('reset', [ResetPasswordController::class, 'handle'])->name('password.reset.handle');
                });
            });

            Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social-auth');
            Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social-auth.callback');
        });
    }
}
