<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'like_blogs')->withTimestamps();
    }

    public function getImageUrlAttribute()
    {
        return $this->blog_image
            ? asset('storage/' . $this->blog_image)
            : null;
    }
}
