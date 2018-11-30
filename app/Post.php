<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * App\Post
 *
 * @mixin \Eloquent
 */
class Post extends Model
{
    protected $fillable = ['user_id', 'header', 'body'];

    public $timestamps = false;

    protected $validators = [
        'user_id' => ['required', 'exists:users,id',],
        'header' => ['required', 'bail', 'max:255', 'string',],
        'body' => ['required', 'string',],
    ];

    public function addPost(array $post): void
    {
        foreach ($post as $key => $value) {
            $this->$key = $value;
        }
    }

    public function validate(): array
    {
        $validator = Validator::make($this->getAttributes(), $this->validators);
        return $validator->errors()->messages();
    }


}
