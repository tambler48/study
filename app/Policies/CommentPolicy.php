<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Post;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    //use HandlesAuthorization;

    protected $operations = [
        Role::ADMIN => ['create', 'update', 'destroy'],
        Role::Moderator => ['create', 'update', 'destroy'],
        Role::User => ['create', 'update_own', 'destroy_own'],
    ];
    /*
     * для хранения операций доступных текущему пользователю
     */
    protected $roleOperates = [];

    public function before(User $user): ?bool
    {
        $role = $user->hasOne('App\Role', 'id', 'role_id')->getResults()->name;
        if ($role === Role::ADMIN) {
            return true;
        }
        if (!array_key_exists($role, $this->operations)) {
            return false;
        }
        $this->roleOperates = $this->operations[$role];
        return null;
    }

    public function create(User $user): bool
    {
        return in_array('create', $this->roleOperates);
    }

    public function update(User $user, Comment $post): bool
    {
        if (in_array('update', $this->roleOperates)) {
            return true;
        }
        return in_array('update_own', $this->roleOperates) && $user->id === $post->user_id;
    }

    public function destroy(User $user, Comment $post): bool
    {
        if (in_array('destroy', $this->roleOperates)) {
            return true;
        }
        return in_array('destroy_own', $this->roleOperates) && $user->id === $post->user_id;
    }
}
