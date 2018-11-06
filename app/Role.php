<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public static function getRoles() {
        return self::select('id', 'name')->get()->pluck('name', 'id');
    }

}
