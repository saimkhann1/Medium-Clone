<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Create Test User ---
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'username' => 'TestUser',
            'email' => 'test@gmail.com',
        ]);

        // --- Create Categories ---
        $categories = ['Technology', 'Health', 'Travel', 'Food', 'Lifestyle', 'Education'];
        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }

        $allCategories = Category::all();

        // --- Create Local Image Path ---
        $seedImages = Storage::disk('public')->files('seed-images');
        if (empty($seedImages)) {
            $this->command->warn('⚠️ No images found in storage/app/public/seed-images. Add at least one image.');
            return;
        }

        // --- Create 10 users, each with 20 posts ---
        User::factory(10)->create()->each(function ($user) use ($allCategories, $seedImages) {
            Post::factory(1000)->create([
                'user_id' => $user->id,
                'category_id' => $allCategories->random()->id,
            ])->each(function ($post) use ($seedImages) {
                $randomImage = Storage::disk('public')->path(collect($seedImages)->random());
                $post->addMedia($randomImage)->preservingOriginal()->toMediaCollection('image');
            });
        });

        // --- Add some posts for Test User ---
        Post::factory(10)->create([
            'user_id' => $testUser->id,
            'category_id' => $allCategories->random()->id,
        ])->each(function ($post) use ($seedImages) {
            $randomImage = Storage::disk('public')->path(collect($seedImages)->random());
            $post->addMedia($randomImage)->preservingOriginal()->toMediaCollection('image');
        });
    }
}
