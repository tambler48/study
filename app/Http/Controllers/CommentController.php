<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use Lang;
use Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    protected $routePrefix = 'user';

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\RedirectResponse
     */
    public function get(int $id): object
    {
        $data = Post::find($id);
        if (empty($data)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found')]]);
            return redirect()->route('user.posts');
        }
        $data = Comment::select()->where('post_id', '=', $id)->get();
        return $data;
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $comment = new Comment;
        if (Gate::denies('create', $comment)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messages.not_add_comment')]]);
            return redirect()->route($this->routePrefix . '.posts');
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
        return redirect()->back();
    }

    public function edit(int $id): \Illuminate\Http\RedirectResponse
    {
        $editComment = Comment::find($id);
        if (empty($editComment)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found_comment')]]);
            return redirect()->route($this->routePrefix . '.posts');
        } elseif (Gate::denies('update', $editComment)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_update_comment')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }
        Session::flash('editComment', $editComment);
        return redirect()->back();
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $comment = new Comment;
        $comment = $comment->find($id);
        if (empty($comment)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found_comment')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }
        if (Gate::denies('update', $comment)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messages.not_update_comment')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }
        $post = $this->trim($request->post());
        $comment->addContent($post);

        $result = $comment->validate();
        if (count($result)) {
            Session::flash('alert', $result);
        }
        $comment->save();
        return redirect()->back();
    }


    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $model = Comment::find($id);
        if (empty($model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found_comment')]]);
        } elseif (Gate::denies('destroy', $model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_delete_comment')]]);
        } else {
            $model = Comment::destroy($id);
        }
        if ($model === 0) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.unknown')]]);
        }
        return redirect()->back();
    }
}
