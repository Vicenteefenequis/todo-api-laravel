<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;
    private const PATH_TO_CREATE_CATEGORY = '/api/v1/categories';


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_category(): void
    {
        $response = $this->actingAs($this->user)->postJson(self::PATH_TO_CREATE_CATEGORY, [
            'name' => 'Esportes',
            'color' => ' #FF0000'
        ]);


        $response->assertStatus(201)->assertJson([
            'name' => 'Esportes',
            'color' => '#FF0000'
        ]);
    }

    public function test_user_cannot_create_category_without_authentication(): void
    {
        $response = $this->postJson(self::PATH_TO_CREATE_CATEGORY, [
            'name' => 'Esportes',
            'color' => ' #FF0000'
        ]);

        $response->assertStatus(401);
    }

    public function test_user_create_category_with_color_invalid(): void
    {
        $response = $this->actingAs($this->user)->postJson(self::PATH_TO_CREATE_CATEGORY, [
            'name' => 'Esportes',
            'color' => 'invalid_color'
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Color invalid_color is not valid!'
        ]);
    }

    public function test_user_find_with_succes(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(self::PATH_TO_CREATE_CATEGORY . "/{$category->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $category->id,
            'name' => $category->name,
            'color' => $category->color,
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at
        ]);
    }

    public function test_user_cannot_find_others_category(): void
    {
        $otherUser = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(self::PATH_TO_CREATE_CATEGORY . "{$category->id}");

        $response->assertStatus(404);
    }

    public function test_user_delete_with_success(): void
    {
        $category = Category::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson(self::PATH_TO_CREATE_CATEGORY . "/{$category->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    public function test_user_cannot_delete_others_category(): void
    {
        $otherUser = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->deleteJson(self::PATH_TO_CREATE_CATEGORY . "{$category->id}");

        $response->assertStatus(404);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }


    public function test_user_list_all_categories(): void
    {
        Category::factory()->count(3)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->getJson(self::PATH_TO_CREATE_CATEGORY);

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'items');
    }

    public function test_user_can_update_category(): void
    {
        $name = 'Esportes';
        $color = '#FFF';

        $category = Category::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->putJson(self::PATH_TO_CREATE_CATEGORY . "/{$category->id}", [
            'name' => $name,
            'color' => $color
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'name' => $name,
            'color' => $color
        ]);

    }


    public function test_user_cannot_update_category_when_color_not_valid(): void
    {
        $name = 'Esportes';
        $color = 'color_not_valid';

        $category = Category::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->putJson(self::PATH_TO_CREATE_CATEGORY . "/{$category->id}", [
            'name' => $name,
            'color' => $color
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => "Color {$color} is not valid!"
        ]);
    }
}
