<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        $social_user = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            $provider.'_id' => $social_user->id,
        ], [
            'name' => $social_user->name ?? $social_user->email,
            'email' => $social_user->email,
            'password' => bcrypt(str()->random(8)),
        ]);

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
