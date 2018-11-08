<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    //use HandlesAuthorization;

    protected $operations = [
        'Admin' => ['create', 'update'],
        'Moderator' => ['create', 'update'],
        'User' => ['create', 'update_own'],
    ];
    /*
     * для хранения операций доступных текущему пользователю
     */
    protected $roleOperates = [];

    public function before(User $user)
    {
        $role = $user->hasOne('App\Role', 'id', 'role_id')->getResults()->name;
        if ($role === 'Admin') {
            return true;
        }
        if (!array_key_exists($role, $this->operations)) {
            return false;
        }
        $this->roleOperates = $this->operations[$role];
    }

    public function create(User $user)
    {
        if (in_array('create', $this->roleOperates)) {
            return true;
        }
        return false;
    }

    public function update(User $user, Post $post)
    {
        if (in_array('update', $this->roleOperates)) {
            return true;
        } elseif (in_array('update_own', $this->roleOperates) && $user->id === $post->user_id) {
            return true;
        }
        return false;
    }

    public function destroy(User $user, Post $post)
    {
        return $this->update($user, $post);
    }

}
