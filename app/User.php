<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


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

    protected function getValidators($id = 0): array
    {
        return [
            'name' => ['required','string', 'max:255'],
            'email' => ['required','string', 'email', 'max:255', 'unique:users,id,' . $id],
            'password' => ['required','string', 'min:6', 'confirmed'],
            'role_id' => ['required','exists:roles,id',],
            'api_token' => ['string', 'nullable', 'unique:users,api_token,' . $id],
        ];
    }

    public static function generateToken(): string
    {
        return str_random(60);
    }

/*    public function validator(array $data, $id = 0, array $valids = []) Пока не нужен
    {
        $validators = $this->getValidators($id); // устанавливает проверку уникальности email кроме выбранного id
        if (count($valids)) {
            $validators = array_merge_recursive($valids, $validators); //добавляет дополнительные правила к валидатору
        }
        return Validator::make($data, $validators);
    }*/

    public function addModel(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function validate($id = 0): array
    {
        $validator = Validator::make($this->getAttributes(), $this->getValidators($id));
        return $validator->errors()->messages();
    }

}
