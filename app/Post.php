<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Post
 *
 * @mixin \Eloquent
 */
class Post extends Model
{
    protected $fillable = ['user_id', 'header', 'body'];
}
