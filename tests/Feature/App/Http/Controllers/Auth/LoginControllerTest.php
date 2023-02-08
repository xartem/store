<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_success()
    {
        $this->get(action([LoginController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.login')
            ->assertSee('E-mail');
    }

    public function test_login_attempt_success()
    {
        $pass = '123456';

        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt($pass),
        ]);

        $request = [
            'email' => $user->email,
            'password' => $pass,
        ];

        $response = $this->post(
            action([LoginController::class, 'handle']),
            $request
        );

        $this->assertAuthenticatedAs($user);

        $response->assertValid()->assertRedirect(route('home'));
    }

    public function test_login_attempt_failed()
    {
        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
        ]);

        $request = [
            'email' => $user->email,
            'password' => '123456',
        ];

        $response = $this->post(
            action([LoginController::class, 'handle']),
            $request
        );

        $this->assertGuest();

        $response->assertInvalid()->assertRedirect();
    }
}
