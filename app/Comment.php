<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Comment extends Model
{

    protected $validators = [
        'post_id' => ['required', 'exists:posts,id',],
        'user_id' => ['required', 'exists:users,id',],
        'body' => ['required', 'string',],
    ];

    public function addContent(array $post): void
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
