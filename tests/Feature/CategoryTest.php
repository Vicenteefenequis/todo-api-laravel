<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;


    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_category(): void
    {
        $response = $this->actingAs($this->user)->postJson('/api/categories', [
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
        $response = $this->postJson('/api/categories', [
            'name' => 'Esportes',
            'color' => ' #FF0000'
        ]);

        $response->assertStatus(401);
    }
}
