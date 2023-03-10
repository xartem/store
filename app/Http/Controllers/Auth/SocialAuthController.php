<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Support\Actions\SessionRegenerateAction;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, SessionRegenerateAction $regenerateAction): RedirectResponse
    {
        $social_user = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            $provider.'_id' => $social_user->getId(),
        ], [
            'name' => $social_user->getName() ?? $social_user->getEmail(),
            'email' => $social_user->getEmail(),
            'password' => bcrypt(str()->random(8)),
        ]);

        $regenerateAction(fn () => auth()->login($user));

        return redirect()->intended(route('home'));
    }
}
