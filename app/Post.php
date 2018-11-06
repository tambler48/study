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

    protected $validators = [
        'user_id' => ['exists:users,id',],
        'header' => ['bail', 'max:255', 'string',],
        'body' => ['string',],
    ];

    public function addPost(array $post)
    {
        foreach ($post as $key => $value) {
            $this->$key = $value;
        }
    }

    public function addValidate(array $valids)
    {
        $this->validators = array_merge_recursive ($valids, $this->validators);
    }

    public function validate(): array
    {
        $validator = Validator::make($this->getAttributes(), $this->validators);
        return $validator->errors()->messages();
    }

}
