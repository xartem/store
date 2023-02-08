<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_page_success()
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.forgot')
            ->assertSee('E-mail');
    }

    public function test_send_reset_password_link_success()
    {
        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
        ]);

        $request = [
            'email' => $user->email,
        ];

        $this->assertGuest();

        $this->post(
            action([ForgotPasswordController::class, 'handle']),
            $request
        )
            ->assertValid()
            ->assertRedirect();
    }
}
