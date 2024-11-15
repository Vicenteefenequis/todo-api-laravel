<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    private User $user;
    private Category $category;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->forUser($this->user->id)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_todo()
    {
        $name = 'Limpeza';
        $description = 'Limpar Armario';

        $response = $this->actingAs($this->user)->postJson('/api/todos', [
            'name' => $name,
            'description' => $description,
            'category_id' => $this->category->id
        ]);


        $response->assertStatus(201);
        $response->assertJson([
            'name' => $name,
            'description' => $description,
            'status' => 'pending',
            'created_at' => $response['created_at'],
            'updated_at' => $response['updated_at'],
        ]);
    }

    public function test_user_cannot_create_todo_without_authentication(): void
    {
        $name = 'Limpeza';
        $description = 'Limpar Armario';

        $response = $this->postJson('/api/todos', [
            'name' => $name,
            'description' => $description,
            'category_id' => $this->category->id
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function test_user_cannot_create_todo_with_category_id_missing(): void
    {
        $name = 'Limpeza';
        $description = 'Limpar Armario';

        $response = $this->actingAs($this->user)->postJson('/api/todos', [
            'name' => $name,
            'description' => $description,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            "message" => "The category id field is required.",
        ]);
    }

    public function test_user_todo_list_with_success(): void
    {
        $count_items = 3;

        Todo::factory()->count($count_items)->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);


        $response = $this->actingAs($this->user)->getJson('/api/todos');

        $response->assertStatus(200);

        $response->assertJsonCount($count_items, 'items');
    }

    public function test_user_todo_list_empty(): void
    {
        $count_items = 0;

        $response = $this->actingAs($this->user)->getJson('/api/todos');

        $response->assertStatus(200);

        $response->assertJsonCount($count_items, 'items');
    }
}
