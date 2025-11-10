<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
 
class Category extends Model
{
    use HasFactory;
 
    protected $fillable = ['name', 'slug'];
 
    // Relationship: A category has many posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
 
    // Automatically create a slug when creating a new category
    protected static function boot()
    {
        parent::boot();
 
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
 
    // Use slug instead of ID for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
}