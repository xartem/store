<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_action_success()
    {
        $email = 'test@gmail.com';

        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(new NewUserDTO(
            'Name',
            $email,
            '123456'
        ));

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }
}
