<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_social_auth_redirect_success()
    {
        $this->get(
            action([SocialAuthController::class, 'redirect'], ['provider' => 'github'])
        )
            ->assertRedirectContains('github.com');
    }

    public function test_social_auth_callback_success()
    {
        $this->assertGuest();

        $response = $this->post(
            action([SocialAuthController::class, 'callback'], ['provider' => 'github'])
        );

        // $this->assertAuthenticated();

        // $response->assertValid()->assertRedirect(route('home'));
    }
}
