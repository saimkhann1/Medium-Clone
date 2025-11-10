<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    $title = $this->faker->sentence();
    return [
        'title' => $title,
        'slug' => Str::slug($title) . '-' . Str::random(5),
        'content' => $this->faker->paragraphs(2, true),
        'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? \App\Models\Category::factory(),
        'user_id' => 1, // ya \App\Models\User::inRandomOrder()->first()?->id
        'published_at' => $this->faker->optional()->dateTime(),
        // 'images' => $this->faker->imageUrl(),
    ];
}

}
