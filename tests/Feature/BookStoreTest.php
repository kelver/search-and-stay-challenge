<?php

namespace Tests\Feature;

use App\Models\BooksStore;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class BookStoreTest extends TestCase
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
        $this->storeAnotherUser = Store::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    public function test_user_not_logged_cant_list_books()
    {
        $response = $this->get("/api/books/{$this->store->uuid}/");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_not_logged_cant_list_books_another_user()
    {
        $response = $this->get("/api/books/{$this->storeAnotherUser->uuid}/");

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_logged_can_list_books()
    {
        $response = $this->get("/api/books/{$this->store->uuid}/", [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_user_logged_cant_list_books_another_user()
    {
        $response = $this->get("/api/books/{$this->storeAnotherUser->uuid}/", [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_not_logged_cant_create_book()
    {
        $response = $this->post("/api/books/{$this->store->uuid}/", [
            'title' => 'Teste',
            'description' => 'Teste',
            'price' => 10.00,
            'quantity' => 10,
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_logged_can_create_book()
    {
        $response = $this->post("/api/books/{$this->store->uuid}/", [
            'name' => 'Teste',
            'author' => 'Teste',
            'isbn' => '123456789',
            'value' => 10.00,
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_logged_cant_create_book_another_user()
    {
        $response = $this->post("/api/books/{$this->storeAnotherUser->uuid}/", [
            'name' => 'Teste',
            'author' => 'Teste',
            'isbn' => '123456789',
            'value' => 10.00,
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_not_logged_cant_update_book()
    {
        $book = BooksStore::factory()->state([
            'store_id' => $this->store->id,
            'user_id' => $this->user->id,
        ])->create();
        $response = $this->put("/api/books/{$this->store->uuid}/{$book->uuid}/", [
            'name' => 'Teste',
            'author' => 'Teste',
            'isbn' => '123456789',
            'value' => 10.00,
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_user_logged_can_update_book()
    {
        $book = BooksStore::factory()->state([
            'store_id' => $this->store->id,
            'user_id' => $this->user->id,
        ])->create();

        $response = $this->put("/api/books/{$this->store->uuid}/{$book->uuid}", [
            'name' => 'Teste Edit',
            'author' => 'Teste',
            'isbn' => '123456789',
            'value' => 10.00,
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_user_logged_cant_update_book_another_user()
    {
        $book = BooksStore::factory()->state([
            'store_id' => $this->store->id,
            'user_id' => $this->user->id,
        ])->create();
        $response = $this->put("/api/books/{$this->storeAnotherUser->uuid}/{$book->uuid}/", [
            'name' => 'Teste',
            'author' => 'Teste',
            'isbn' => '123456789',
            'value' => 10.00,
        ], [
            'Authorization' => "Bearer {$this->token}"
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
