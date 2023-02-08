<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function page(): View|Factory
    {
        return view('auth.register');
    }

    public function handle(RegisterRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        $action($request->name, $request->email, $request->password);

        return redirect()->route('home');
    }
}
