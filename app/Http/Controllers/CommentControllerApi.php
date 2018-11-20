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
            return $this->jsonResponse(Lang::get('messagesPost.not_found'), 400);
        }
        $data = Comment::select()->where('post_id', '=', $id)->get();
        if (!$data->count()) {
            $data = [Lang::get('messagesPost.not_found_comment')];
        }
        return $this->jsonResponse($data, 200);
    }

    public function show(int $id): JsonResponse
    {
        $data = Comment::find($id);
        if (empty($data)) {
            return $this->jsonResponse(Lang::get('messagesPost.not_found_comment'), 400);
        }
        return $this->jsonResponse($data, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $comment = new Comment;
        if (Gate::denies('create', $comment)) {
            return $this->jsonResponse([Lang::get('messagesPost.not_add_comment')], 400);
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
            Session::flash('alert', $result);
        } else {
            $comment->save();
        }
        return $this->jsonResponse([Lang::get('messagesPost.create_comment'), $comment], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $comment = new Comment;
        $comment = $comment->find($id);
        if (empty($comment)) {
            return $this->jsonResponse(Lang::get('messagesPost.not_found_comment'), 400);
        }
        if (Gate::denies('update', $comment)) {
            return $this->jsonResponse(Lang::get('messagesPost.not_update_comment'), 400);
        }
        $post = $this->trim($request->post());
        $comment->addContent($post);
        $result = $comment->validate();
        if (count($result)) {
            return $this->jsonResponse($result, 400);
        }
        $comment->save();
        return $this->jsonResponse([Lang::get('messagesPost.update_comment'), $comment], 201);
    }


    public function destroy(int $id): JsonResponse
    {
        $model = Comment::find($id);
        if (empty($model)) {
            return $this->jsonResponse(Lang::get('messagesPost.not_found_comment'), 400);
        } elseif (Gate::denies('destroy', $model)) {
            return $this->jsonResponse(Lang::get('messagesPost.not_delete_comment'), 400);
        } else {
            $model = Comment::destroy($id);
        }
        if ($model === 0) {
            return $this->jsonResponse(Lang::get('messagesPost.unknown'), 400);
        }
        return $this->jsonResponse(Lang::get('messagesPost.delete_comment'), 201);
    }
}
