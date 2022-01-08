<?php

namespace Tests\Unit;

use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('app:install');
    }

    public function test_can_login_with_correct_credentials()
    {
        $this->postJson(route('users.auth.login'), [
            'email' => 'user1@example.com',
            'password' => 'password'
        ])->assertSuccessful()->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'token']
        ])->assertJson([
            'success'=> true,
            'message' => 'Logged In Successfully'
        ]);
    }

    public function test_login_with_invalid_credentials()
    {
        $this->postJson(route('users.auth.login'), [
            'email' => 'user1@example.com',
            'password' => 'invalid-password'
        ])->assertStatus(Response::HTTP_BAD_REQUEST)->assertJson([
            'success'=> false,
            'message' => 'Invalid Email/Password'
        ]);
    }

    public function test_login_with_missing_credentials()
    {
        $this->postJson(route('users.auth.login'), [
            'email' => 'user1@example.com',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['message', 'data' => ['errors' => ['password']]])
            ->assertJson(['success'=> false,'message' => 'Validation Error']);
    }
}
