<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LoginController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $request;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = [
            'email' => 'test@gmail.com',
            'password' => '123456',
        ];
    }

    public function test_login_page_success()
    {
        $this->get(action([LoginController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.login')
            ->assertSee('E-mail');
    }

    public function test_login_attempt_success()
    {
        $user = UserFactory::new()->create([
            'email' => $this->request['email'],
            'password' => bcrypt($this->request['password']),
        ]);

        $response = $this->post(
            action([LoginController::class, 'handle']),
            $this->request
        );

        $this->assertAuthenticatedAs($user);

        $response->assertValid()->assertRedirect(route('home'));
    }

    public function test_login_attempt_failed()
    {
        $user = UserFactory::new()->create([
            'email' => $this->request['email'],
            'password' => bcrypt($this->request['password']),
        ]);

        $this->request['password'] = '222222';

        $response = $this->post(
            action([LoginController::class, 'handle']),
            $this->request
        );

        $this->assertGuest();

        $response->assertInvalid()->assertRedirect();
    }
}
