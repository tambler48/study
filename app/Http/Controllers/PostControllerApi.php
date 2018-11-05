<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Post;
use Gate;

class PostControllerApi extends Controller
{

    public function index(): JsonResponse
    {

        $model = Post::all();
        if (!count($model)) {
            return $this->jsonResponse('Not found posts', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function store(Request $request): JsonResponse
    {

        $post = $this->trim($request->post());
        $model = new Post;

        if (Gate::denies('create', $model)) {
            return $this->jsonResponse(['You can not create posts.'], 400);
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
        } else {
            $model->timestamps = false;
            $model->save();
        }
        return $this->jsonResponse(['Post successfully added', $model], 201);
    }

    public function show($id): JsonResponse
    {

        $data = Post::find($id);
        if (!empty($data)) {
            return $this->jsonResponse($data, 200);
        }
        return $this->jsonResponse('Not found post', 400);
    }

    public function update(Request $request, $id): JsonResponse
    {

        $model = new Post;
        $model = $model->find($id);

        if (Gate::denies('update', $model)) {
            return $this->jsonResponse(['You can not update posts.'], 400);
        }

        if (empty($model)) {
            return $this->jsonResponse(['Alert' => ['Not found post']], 400);
        } else {
            $post = $this->trim($request->post());
            $model->addPost($post);
            $result = $model->validate();
            if (count($result)) {
                return $this->jsonResponse($result, 400);
            } else {
                $model->timestamps = false;
                $model->save();
            }
        }
        return $this->jsonResponse(['Post successfully updated', $model], 201);

    }

    public function destroy(int $id): JsonResponse
    {

        $model = Post::find($id);
        if (empty($model)) {
            return $this->jsonResponse(['Alert' => ['Not found post']], 400);
        } elseif (Gate::denies('update', $model)) {
            return $this->jsonResponse(['You can not delete posts.'], 400);
        } else {
            $model = Post::destroy($id);
        }
        if ($model === 0) {
            return $this->jsonResponse(['Alert' => ['Unknown error']], 400);
        }
        return $this->jsonResponse(['Post successfully deleted'], 201);
    }

}
