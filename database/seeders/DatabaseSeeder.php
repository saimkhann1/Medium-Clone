<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     User::factory()->create([
        'name'=>'Test User',
        'username'=>'TestUser',
        'email'=>'test@gmail.com'
     ]);

    $categories = ['Technology', 'Health', 'Travel', 'Food', 'Lifestyle', 'Education'];
    foreach ($categories as $category) {
        Category::create(['name'=>$category]);
    }

    // Post::factory(50)->create();
}
}