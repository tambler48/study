<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function allPosts(): object {
        $posts = \App\Post::all();     //получение всех записей (для всех)
        return view('study.posts', compact('posts'));
    }

    public function postById(int $id): object {      //получение записи по id (для всех)
        $post = \App\Post::find($id);
        if (empty($post)) {
            abort(404);
        }
        return view('study.post', compact('post')) ;
    }

    public function createFormPost(): object {   //получение формы создания записи (для админа)
            $id = Auth::id();
            return view('study.createForm', compact('id'));
    }

    public function createPost(Request $request): object {   // запись новой записи в БД (для админа)

        $this->validate($request, [
            'user' => 'exists:users,id',
            'header' => 'bail|required|max:255',
            'body' => 'required',
        ]);

        $model = new \App\Post;
        $model->user_id = $request->user;
        $model->header = $request->header;
        $model->body = $request->body;
        $model->timestamps = false;
        $model->save();
        return redirect('/admin/posts');
    }

    public function allPostsAdmin(): object {//получение всех записей с дополнительными кнопками (для админа)
        $posts = \App\Post::all();
        $buttons = true;
        return view('study.posts', compact('posts', 'buttons'));
    }

    public function unsetPost(int $id): object {// удаление записи (для админа)
        \App\Post::destroy($id);
        return redirect('/admin/posts');

    }

    public function editFormPost(int $id): object {//получение формы редактирования записи (для админа)
        $post = \App\Post::find($id);
        $id = Auth::id();
        return view('study.editForm', compact('post', 'id')) ;
    }


    public function editPost(Request $request) {// запись отредактированой записи в БД (для админа)
        $this->validate($request, [
            'user' => 'exists:users,id',
            'post_id' => 'exists:posts,id',
            'header' => 'bail|required|max:255',
            'body' => 'required',
        ]);

        $model = \App\Post::find($request->post_id);
        $model->user_id = $request->user;
        $model->header = $request->header;
        $model->body = $request->body;
        $model->timestamps = false;
        $model->save();
        return redirect('/admin/posts');
    }


}
