<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Post;
use App\Comment;
use Lang;
use Gate;

class CommentControllerApi extends Controller
{
    public function get(int $id): JsonResponse
    {
        $data = Post::find($id);
        if (empty($data)) {
            return $this->jsonResponse('', 404);
        }
        $data = Comment::select()->where('post_id', '=', $id)->get();
        if (!$data->count()) {
            return $this->jsonResponse('', 404);
        }
        return $this->jsonResponse($data, 200);
    }

    public function show(int $id): JsonResponse
    {
        $data = Comment::find($id);
        if (empty($data)) {
            return $this->jsonResponse('', 404);
        }
        return $this->jsonResponse($data, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $comment = new Comment;
        if (Gate::denies('create', $comment)) {
            return $this->jsonResponse('', 403);
        }
        $post = $this->trim($request->post());
        $comment->addContent($post);

        $comment->addValidate([
            'post_id' => ['required',],
            'user_id' => ['required',],
            'body' => ['required',],
        ]);
        $result = $comment->validate();
        if (count($result)) {
            return $this->jsonResponse($result, 406);
        }
        $comment->save();
        return $this->jsonResponse( $comment, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $comment = new Comment;
        $comment = $comment->find($id);
        if (empty($comment)) {
            return $this->jsonResponse('', 404);
        }
        if (Gate::denies('update', $comment)) {
            return $this->jsonResponse('', 403);
        }
        $post = $this->trim($request->post());
        $comment->addContent($post);
        $result = $comment->validate();
        if (count($result)) {
            return $this->jsonResponse($result, 406);
        }
        $comment->save();
        return $this->jsonResponse( $comment, 201);
    }


    public function destroy(int $id): JsonResponse
    {
        $model = Comment::find($id);
        if (empty($model)) {
            return $this->jsonResponse('', 404);
        } elseif (Gate::denies('destroy', $model)) {
            return $this->jsonResponse('', 403);
        } else {
            $model = Comment::destroy($id);
        }
        if ($model === 0) {
            return $this->jsonResponse('', 418);
        }
        return $this->jsonResponse('', 204);
    }
}
