<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Comment extends Model
{

    protected $validators = [
        'post_id' => ['exists:posts,id',],
        'user_id' => ['exists:users,id',],
        'body' => ['string',],
    ];

    public function addContent(array $post)
    {
        foreach ($post as $key => $value) {
            $this->$key = $value;
        }
    }

    public function addValidate(array $valids)
    {
        $this->validators = array_merge_recursive($valids, $this->validators);
    }

    public function validate(): array
    {
        $validator = Validator::make($this->getAttributes(), $this->validators);
        return $validator->errors()->messages();
    }


}
