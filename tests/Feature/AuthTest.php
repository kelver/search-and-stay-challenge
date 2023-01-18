<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_user_not_logged_cant_see_data()
    {
        $response = $this->json(
            'GET',
            '/api/me',
            [],
            ['Accept' => 'application/json']
        );

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_check_user_logged_can_see_data()
    {
        $token = JWTAuth::fromUser(User::factory()->create());

        $response = $this->json(
            'GET',
            '/api/me',
            [],
            ['Authorization' => 'Bearer ' . $token]
        )->assertStatus(Response::HTTP_OK);
    }
}
