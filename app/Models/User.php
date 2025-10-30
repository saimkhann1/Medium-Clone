<?php

namespace App\Models;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, \Spatie\MediaLibrary\InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'image',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

 public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}
    public function hasClapped(Post $post)
    {
        return $this->claps()->where('post_id', $post->id)->exists();
    }
    public function claps()
{
    return $this->hasMany(\App\Models\Clap::class);
}

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }
   public function isFollowedBy(?User $user): bool
{
    if (!$user) {
        return false;
    }

    return $this->followers()
        ->where('follower_id', $user->id)
        ->exists();
}


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->crop(128,128)
            ->width(128);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->singleFile();
    }
  public function imageUrl()
    {
        $media = $this->getFirstMedia('avatars');

        if ($media && $media->hasGeneratedConversion('avatar')) {
            return $media->getUrl('avatar');
        }

        return $media ? $media->getUrl() : null;
    }
}
