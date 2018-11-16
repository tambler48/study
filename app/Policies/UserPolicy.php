<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    //use HandlesAuthorization;

    protected $operations = [
        Role::ADMIN => ['view', 'create', 'update', 'destroy', 'remove', 'restore',],
        Role::Moderator => ['view', 'remove', ],
    ];
    /*
    * для хранения операций доступных текущему пользователю
    */
    protected $roleOperates = [];

    public function before(User $user): ?bool
    {
        $role = $user->hasOne('App\Role', 'id', 'role_id')->getResults()->name;
        if (!array_key_exists($role, $this->operations)) {
            return false;
        }
        $this->roleOperates = $this->operations[$role];
        return null;
    }

    public function view(User $user): bool
    {
        if (in_array('view', $this->roleOperates)) {
            return true;
        }
        return false;
    }

    public function create(User $user): bool
    {
        if (in_array('create', $this->roleOperates)) {
            return true;
        }
        return false;
    }

    public function update(User $user, User $model): bool
    {
        if (in_array('update', $this->roleOperates)) {
            return true;
        } elseif (in_array('update_own', $this->roleOperates) && $user->id === $model->user_id) {
            return true;
        }
        return false;
    }

    public function destroy(User $user, User $model): bool
    {
        if (in_array('destroy', $this->roleOperates)) {
            return true;
        }
        return false;
    }

    public function remove(User $user, User $model): bool
    {
        if($model->active === 1 && in_array('remove', $this->roleOperates)){
            return false;
        }
        return false;
    }

    public function restore(User $user, User $model): bool
    {
        if($model->active === 0 && in_array('restore', $this->roleOperates)){
            return true;
        }
        return false;
    }

}
