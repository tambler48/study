<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Post;
use Gate;
use Lang;

class PostControllerApi extends Controller
{

    public function index(): JsonResponse
    {
        $model = Post::all();
        if (!count($model)) {
            return $this->jsonResponse(Lang::get('messages.not_found', ['subject' => 'post']), 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $post = $this->trim($request->post());
        $model = new Post;

        if (Gate::denies('create', $model)) {
            return $this->jsonResponse(Lang::get('messages.not_create', ['subject' => 'post']), 400);
        }

        $model->addPost($post);
        $model->addValidate([
            'user_id' => ['required',],
            'header' => ['required',],
            'body' => ['required',],
        ]);
        $result = $model->validate();
        if (count($result)) {
            return $this->jsonResponse($result, 400);
        }
        $model->timestamps = false;
        $model->save();
        return $this->jsonResponse([Lang::get('messages.create', ['subject' => 'Post']), $model], 201);
    }

    public function show($id): JsonResponse
    {
        $data = Post::find($id);
        if (!empty($data)) {
            return $this->jsonResponse($data, 200);
        }
        return $this->jsonResponse(Lang::get('messages.not_found', ['subject' => 'post']), 400);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $model = new Post;
        $model = $model->find($id);

        if (Gate::denies('update', $model)) {
            return $this->jsonResponse(Lang::get('messages.not_update', ['subject' => 'post']), 400);
        }

        if (empty($model)) {
            return $this->jsonResponse(Lang::get('messages.not_found', ['subject' => 'post']), 400);
        }

        $post = $this->trim($request->post());
        $model->addPost($post);
        $result = $model->validate();
        if (count($result)) {
            return $this->jsonResponse($result, 400);
        }
        $model->timestamps = false;
        $model->save();

        return $this->jsonResponse([Lang::get('messages.update', ['subject' => 'Post']), $model], 201);

    }

    public function destroy(int $id): JsonResponse
    {
        $model = Post::find($id);
        if (empty($model)) {
            return $this->jsonResponse(Lang::get('messages.not_found', ['subject' => 'post']), 400);
        }
        if (Gate::denies('destroy', $model)) {
            return $this->jsonResponse(Lang::get('messages.not_delete', ['subject' => 'post']), 400);
        }
        $model = Post::destroy($id);

        if ($model === 0) {
            return $this->jsonResponse(Lang::get('messages.unknown'), 400);
        }
        return $this->jsonResponse(Lang::get('messages.delete', ['subject' => 'Post']), 201);
    }

}
