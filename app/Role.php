<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public const ADMIN = 'Admin';
    public const Moderator = 'Moderator';
    public const User = 'User';

    public static function getRoles()
    {
        return self::select('id', 'name')->get()->pluck('name', 'id');
    }

}
