<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia,HasSlug;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('default')
            ->width(400);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function readTime($wordsPerMinute = 100)
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordsPerMinute);
        return max(1, $minutes);
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    }
public function imageUrl()
{
    $url = $this->getFirstMediaUrl('image') ?: $this->getFirstMediaUrl();

    if ($url && $url !== '') {
        return $url;
    }

    if ($this->image) {
        return asset('storage/seed-images/' . $this->image);
    }

    return asset('images/default-post.jpg');
}
}                       