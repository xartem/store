<?php

namespace Tests\Feature\Auth\DTOs;

use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    public function test_instance_created_from_request()
    {
        $dto = NewUserDTO::fromRequest((new Request())->merge([
            'email' => 'test@gmail.com',
            'name' => 'Name',
            'password' => '123456',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
