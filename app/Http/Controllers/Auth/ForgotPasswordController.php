<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Domain\Auth\Contracts\SendResetPasswordLinkContract;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
    public function page(): View|Factory
    {
        return view('auth.forgot');
    }

    public function handle(ForgotPasswordRequest $request, SendResetPasswordLinkContract $action): RedirectResponse
    {
        return $action($request->email)
            ? back()->with(['message' => 'Отправили'])
            : back()->withErrors(['email' => 'Ошибка']);
    }
}
