<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Default fake data for one category.
     * If no user_id is provided when calling the factory, it will create a User.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name'    => fake()->unique()->word(),
            'type'    => fake()->randomElement(['income', 'expense']),
        ];
    }
}