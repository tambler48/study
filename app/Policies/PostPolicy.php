<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    //use HandlesAuthorization;

    public function create(User $user)
    {
        $role = $user->role_id;
        if ($role === 1 || $role === 2 || $role === 3) {
            return true;
        }
        return false;
    }

    public function update(User $user, Post $post)
    {
        $role = $user->role_id;
        if ($role === 1 || $role === 2) {
            return true;
        } elseif ($role === 3 && $user->id === $post->user_id) {
            return true;
        }
        return false;
    }

}
