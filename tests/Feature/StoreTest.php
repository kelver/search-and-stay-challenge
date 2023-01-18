<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected mixed $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->store = Store::factory()->state([
            'user_id' => $this->user->id,
        ])->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    public function test_user_not_logged_cant_access()
    {
        $response = $this->get('/api/stores/');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_cant_update_stores()
    {
        $store = Store::factory()->state([
            'user_id' => User::factory()->state([
                'name' => 'Teste',
            ])->create()->id,
        ])->create();

        $response = $this->put("/api/stores/{$store->uuid}", [
            'name' => 'Name Edit',
        ],[
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_cant_create_stores_without_name()
    {
        $response = $this->post("/api/stores/", [
            'name' => null,
        ],[
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_cant_show_stores_another_account()
    {
        $store = Store::factory()->state([
            'user_id' => User::factory()->state([
                'name' => 'Teste',
            ])->create()->id,
        ])->create();

        $response = $this->get("/api/stores/{$store->uuid}",[
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_can_create_stores()
    {
        $response = $this->post("/api/stores/", [
            'name' => 'Store Test',
        ],[
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_can_show_stores()
    {
        $response = $this->get("/api/stores/{$this->store->uuid}",[
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_user_can_update_stores()
    {
        $response = $this->put("/api/stores/{$this->store->uuid}", [
            'name' => 'Name Edit',
        ],[
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
