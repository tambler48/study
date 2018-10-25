<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostControllerApi extends Controller
{

    public function index(): JsonResponse
    {
        $model = \App\Post::all();

        if (!count($model)) {
            return $this->jsonResponse('Not found posts', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->post(), [
            'user_id' => ['required', 'exists:users,id',],
            'header' => ['bail', 'required', 'max:255', 'string',],
            'body' => ['required', 'string',],
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400);
        }

        $model = new \App\Post;
        $model->user_id = $request->user_id;
        $model->header = $request->header;
        $model->body = $request->body;
        $model->timestamps = false;
        $model->save();
        return $this->jsonResponse(['Post successfully added', $model->getAttributes()], 201);
    }

    public function show($id): JsonResponse
    {
        $model = \App\Post::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found post', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {

        $model = \App\Post::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found post', 400);
        }

        $validator = Validator::make($request->post(), [
            'user_id' => ['bail', 'exists:users,id',],
            'header' => ['bail', 'string', 'max:255',],
            'body' => ['string',],
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400);
        }

        $model->user_id = $request->user_id ?? $model->user_id;
        $model->header = $request->header ?? $model->header;
        $model->body = $request->body ?? $model->body;
        $model->timestamps = false;
        $model->save();
        return $this->jsonResponse(['Post successfully updated', $model->getAttributes()], 201);
    }

    public function destroy($id): JsonResponse
    {

        $model = \App\Post::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found post', 400);
        }

        $model = \App\Post::destroy($id);
        if ($model === 0) {
            return $this->jsonResponse('Unknown error', 400);
        }
        return $this->jsonResponse('Post successfully deleted', 201);
    }

}
