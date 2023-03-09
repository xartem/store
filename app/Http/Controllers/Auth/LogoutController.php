<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LogoutRequest;
use Support\Actions\SessionRegenerateAction;

class LogoutController extends Controller
{
    public function __invoke(LogoutRequest $request, SessionRegenerateAction $regenerateAction)
    {
        $regenerateAction(fn () => auth()->logout());

        return redirect()->route('home');
    }
}
