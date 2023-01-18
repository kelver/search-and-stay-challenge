<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected mixed $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    public function test_user_cant_register()
    {
        $user = User::factory()->state([
            'password_confirmation' => ''
        ])->make();

        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
        ]);
    }

    public function test_user_register()
    {
        $this->actingAs($this->user, 'api');
        $this->assertNotNull($this->token);
    }

    public function test_fail_user_access()
    {
        $this->assertInvalidCredentials([
            'email' => $this->user->email,
            'password' => '',
        ]);
    }

    public function test_user_access()
    {
        $this->assertCredentials([
            'email' => $this->user->email,
            'password' => 'password',
        ]);
        $this->actingAs($this->user, 'api');
        $this->assertNotNull($this->token);
    }
}
