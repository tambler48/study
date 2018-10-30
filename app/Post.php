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
        foreach ($post as $key => $value){
            $this->$key = $value;
        }
    }

    public function addValidate(array $valids)
    {
        foreach ($valids as $k=>$v){
            array_key_exists($k, $this->validators)?: $this->validators[$k] = [] ;
            array_unshift($this->validators[$k], $v);
        }
    }

    public function validate(): array
    {
        $validator = Validator::make($this->getAttributes(), $this->validators);
        return $validator->errors()->messages();
    }




    public function create(Request $request): array
    {

        $validator = Validator::make($request->post(), [
            'user_id' => ['required', 'exists:users,id',],
            'header' => ['bail', 'required', 'max:255', 'string',],
            'body' => ['required', 'string',],
        ]);
        if ($validator->fails()) {
            return [$validator->errors()->messages(), 400];
        }
        $model = new \App\Post;
        $model->user_id = $request->user_id;
        $model->header = $request->header;
        $model->body = $request->body;
        $model->timestamps = false;
        $model->save();
        return [$model->getAttributes(), 201];
    }

    public function edit(Request $request, $id): array
    {

        $model = \App\Post::find($id);
        if (empty($model)) {
            return [['Alert' => ['Not found post']], 400];
        }
        $validator = Validator::make($request->post(), [
            'user_id' => ['bail', 'exists:users,id',],
            'header' => ['bail', 'string', 'max:255',],
            'body' => ['string',],
        ]);
        if ($validator->fails()) {
            return [$validator->errors()->messages(), 400];
        }
        $model->user_id = $request->user_id ?? $model->user_id;
        $model->header = $request->header ?? $model->header;
        $model->body = $request->body ?? $model->body;
        $model->timestamps = false;
        $model->save();
        return [$model->getAttributes(), 201];
    }


}
