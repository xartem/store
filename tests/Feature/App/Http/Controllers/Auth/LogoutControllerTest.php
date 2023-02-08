<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\LogoutController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_attempt_success()
    {
        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
        ]);

        $this->actingAs($user)->delete(
            action([LogoutController::class])
        );

        $this->assertGuest();
    }

    public function test_logout_attempt_failed()
    {
        $this->assertGuest();

        $this->delete(
            action([LogoutController::class])
        )
            ->assertRedirect(route('login'));
    }
}
