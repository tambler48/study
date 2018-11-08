<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    //use HandlesAuthorization;

    protected $operations = [
        'Admin' => ['look', 'create', 'update',],
        'Moderator' => ['look',],
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

    public function look(User $user)
    {
        if (in_array('look', $this->roleOperates)) {
            return true;
        }
        return false;
    }

    public function create(User $user)
    {
        if (in_array('create', $this->roleOperates)) {
            return true;
        }
        return false;
    }

    public function update(User $user, User $model)
    {
        if (in_array('update', $this->roleOperates)) {
            return true;
        } elseif (in_array('update_own', $this->roleOperates) && $user->id === $model->user_id) {
            return true;
        }
        return false;
    }

    public function destroy(User $user, User $model)
    {
        return $this->update($user, $model);
    }
}