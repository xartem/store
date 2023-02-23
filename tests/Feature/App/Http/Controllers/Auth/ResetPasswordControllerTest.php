<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ResetPasswordController;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_page_success()
    {
        $this->get(action([ResetPasswordController::class, 'page'], ['token' => '123445']))
            ->assertOk()
            ->assertViewIs('auth.reset')
            ->assertSee('E-mail');
    }

    public function test_reset_password_success()
    {
        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
        ]);

        $token = Password::createToken($user);

        $request = [
            'email' => $user->email,
            'token' => $token,
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->post(
            action([ResetPasswordController::class, 'handle']),
            $request
        )
            ->assertValid()
            ->assertRedirect(route('login'));

        $this->assertTrue(Hash::check($request['password'], $user->fresh()->password));

        Event::assertDispatched(PasswordReset::class);
    }
}
