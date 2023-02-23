<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
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

    public function it_driver_not_found_exception(): void
    {
        $this->expectException(\DomainException::class);

        $this->withoutExceptionHandling()
            ->get(
                action([SocialAuthController::class, 'redirect'], ['driver' => 'facebook'])
            );

        $this->withoutExceptionHandling()
            ->get(
                action(
                    [SocialAuthController::class, 'callback'], ['driver' => 'facebook']
                )
            );
    }

    public function test_github_callback_created_user_success(): void
    {
        $githubId = str()->random(10);

        $this->assertDatabaseMissing('users', [
            'github_id' => $githubId,
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId,
        ]);
    }

    private function callbackRequest(): TestResponse
    {
        return $this->get(
            action([SocialAuthController::class, 'callback'], ['provider' => 'github'])
        );
    }

    private function mockSocialiteCallback(string|int $githubId): MockInterface
    {
        $user = $this->mock(SocialiteUser::class, function (MockInterface $m) use ($githubId) {
            $m->shouldReceive('getId')
                ->once()
                ->andReturn($githubId);

            $m->shouldReceive('getName')
                ->once()
                ->andReturn(str()->random(10));

            $m->shouldReceive('getEmail')
                ->once()
                ->andReturn('testing@test.com');
        });

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($user);

        return $user;
    }
}
