<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => (string) Str::uuid(),
            'name' => $this->faker->name(),
            'color' => $this->faker->hexColor(),
            'user_id' => (string) Str::uuid(),
        ];
    }

    public function forUser(string $userId){
        return $this->state([
            'user_id' => $userId
        ]);
    }
}
