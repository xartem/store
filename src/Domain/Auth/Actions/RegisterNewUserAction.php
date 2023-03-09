<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Support\Actions\SessionRegenerateAction;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $userDTO): User
    {
        $user = User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => bcrypt($userDTO->password),
        ]);

        event(new Registered($user));

        (new SessionRegenerateAction)(fn () => auth()->login($user));

        return $user;
    }
}
