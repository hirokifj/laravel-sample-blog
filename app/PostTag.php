<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
