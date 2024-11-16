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
    private const PATH_TO_CREATE_TODOS = '/api/v1/todos';


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

        $response = $this->actingAs($this->user)->postJson(self::PATH_TO_CREATE_TODOS, [
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

        $response = $this->postJson(self::PATH_TO_CREATE_TODOS, [
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

        $response = $this->actingAs($this->user)->postJson(self::PATH_TO_CREATE_TODOS, [
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


        $response = $this->actingAs($this->user)->getJson(self::PATH_TO_CREATE_TODOS);

        $response->assertStatus(200);

        $response->assertJsonCount($count_items, 'items');
    }

    public function test_user_todo_list_empty(): void
    {
        $count_items = 0;

        $response = $this->actingAs($this->user)->getJson(self::PATH_TO_CREATE_TODOS);

        $response->assertStatus(200);

        $response->assertJsonCount($count_items, 'items');
    }

    public function test_user_todo_find_with_success()
    {

        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->getJson(self::PATH_TO_CREATE_TODOS . "/{$todo->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $todo->id
        ]);
    }

    public function test_user_todo_find_not_found()
    {


        $response = $this->actingAs($this->user)->getJson(self::PATH_TO_CREATE_TODOS . "/not_found_id");

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Todo with id not_found_id not found'
        ]);
    }

    public function test_user_todo_delete_with_success()
    {

        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->deleteJson(self::PATH_TO_CREATE_TODOS . "/{$todo->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function test_user_todo_delete_not_found()
    {

        $response = $this->actingAs($this->user)->deleteJson(self::PATH_TO_CREATE_TODOS . "/not_found_id");

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Todo with id not_found_id not found'
        ]);
    }

    public function test_user_todo_update_with_success()
    {
        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $another_category = Category::factory()->forUser($this->user->id)->create();

        $response = $this->actingAs($this->user)->putJson(self::PATH_TO_CREATE_TODOS . "/{$todo->id}", [
            'name' => 'another_name',
            'description' => 'another description',
            'category_id' => $another_category->id
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'another_name',
            'description' => 'another description',
        ]);
    }


    public function test_user_todo_update_not_found()
    {
        $another_category = Category::factory()->forUser($this->user->id)->create();

        $response = $this->actingAs($this->user)->putJson(self::PATH_TO_CREATE_TODOS . "/not_found", [
            'name' => 'another_name',
            'description' => 'another description',
            'category_id' => $another_category->id
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Todo with id not_found not found'
        ]);
    }

    public function test_user_todo_change_status_with_success()
    {
        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->patchJson(self::PATH_TO_CREATE_TODOS . "/{$todo->id}/status", [
            'status' => 'completed',
        ]);

        $response->assertStatus(204);
    }


    public function test_user_todo_change_status_with_error_status_unknown()
    {
        $todo = Todo::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->patchJson(self::PATH_TO_CREATE_TODOS . "/{$todo->id}/status", [
            'status' => 'unknown_status',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The selected status is invalid.'
        ]);
    }

    public function test_user_todo_change_status_with_not_found_todo()
    {

        $response = $this->actingAs($this->user)->patchJson(self::PATH_TO_CREATE_TODOS . "/not_found_id/status", [
            'status' => 'pending',
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'Todo with id not_found_id not found'
        ]);
    }


}
