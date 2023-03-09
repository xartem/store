<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Support\Actions\SessionRegenerateAction;

class LoginController extends Controller
{
    public function page(): View|Factory
    {
        return view('auth.login');
    }

    public function handle(LoginRequest $request, SessionRegenerateAction $regenerateAction): RedirectResponse
    {
        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $regenerateAction();

        return redirect()->intended(route('home'));
    }
}
