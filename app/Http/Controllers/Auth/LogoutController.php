<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutRequest;

class LogoutController extends Controller
{
    public function __invoke(LogoutRequest $request)
    {
        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
