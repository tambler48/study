<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'api_token'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'email_verified_at'
    ];

    protected function getValidators($id = 0)
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users,id,' . $id],
            'password' => ['string', 'min:6', 'confirmed'],
            'role_id' => ['exists:roles,id',],
        ];
    }

    public static function generateToken()
    {
        return str_random(60);

    }

    public function validator(array $data, $id = 0, array $valids = [])
    {
        $validators = $this->getValidators($id); // устанавливает проверку уникальности email кроме выбранного id
        if (count($valids)) {
            $validators = array_merge_recursive($valids, $validators); //добавляет дополнительные правила к валидатору
        }
        return Validator::make($data, $validators);
    }

    public function addModel(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function validate(): array
    {
        $validator = Validator::make($this->getAttributes(), $this->validators);
        return $validator->errors()->messages();
    }

}
