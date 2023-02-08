<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\RegisterController;
use App\Listeners\SendEmailNewUserCreatedListener;
use App\Notifications\NewUserCreatedNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_success()
    {
        $response = $this->get(
            action([RegisterController::class, 'page'])
        )
            ->assertOk()
            ->assertViewIs('auth.register')
            ->assertSee('E-mail');
    }

    public function test_register_attempt_success()
    {
        Event::fake();
        Notification::fake();

        $request = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);

        $response = $this->post(
            action([RegisterController::class, 'handle']),
            $request
        );

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        $user = User::whereEmail($request['email'])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserCreatedListener::class);

        (new SendEmailNewUserCreatedListener())->handle(new Registered($user));

        Notification::assertSentTo($user, NewUserCreatedNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

    public function test_register_attempt_failed()
    {
        $request = [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        UserFactory::new()->create([
            'email' => $request['email'],
        ]);

        $this->post(
            action([RegisterController::class, 'handle']),
            $request
        )
            ->assertInvalid()
            ->assertRedirect();

        $this->assertGuest();
    }
}
