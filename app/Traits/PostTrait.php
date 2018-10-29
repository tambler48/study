<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

trait PostTrait
{

    public function takeAll(): array
    {

        $model = \App\Post::all();
        if (!count($model)) {
            return [$model, 400];
        }
        return [$model, 200];
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

    public function byId($id): array
    {

        $model = \App\Post::find($id);
        if (empty($model)) {
            return [['Alert' => ['Not found post']], 400];
        }
        return [$model, 200];
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

    public function delete($id): array
    {

        $model = \App\Post::find($id);
        if (empty($model)) {
            return [['Alert' => ['Not found post']], 400];
        }
        $model = \App\Post::destroy($id);
        if ($model === 0) {
            return [['Alert' => ['Unknown error']], 400];
        }
        return ['Post successfully deleted', 201];
    }


}