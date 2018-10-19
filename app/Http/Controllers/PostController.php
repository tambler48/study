<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function all(): \Illuminate\View\View  {
        $posts = \App\Post::all();     //получение всех записей (для всех)
        return view('posts.all', compact('posts'));
    }

    public function byId(int $id): \Illuminate\View\View {      //получение записи по id (для всех)
        $post = \App\Post::find($id);
        if (empty($post)) {
            abort(404);
        }
        return view('posts.post', compact('post')) ;
    }

    public function createForm(): \Illuminate\View\View {   //получение формы создания записи (для админа)
            $id = Auth::id();
            return view('posts.createForm', compact('id'));
    }

    public function create(Request $request): \Illuminate\Http\RedirectResponse {   // запись новой записи в БД (для админа)

        $request->validate([
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
        return redirect('/user/posts');
    }

    public function allUser(): \Illuminate\View\View {//получение всех записей с дополнительными кнопками (для админа)
        $posts = \App\Post::all();
        $buttons = true;
        return view('posts.all', compact('posts', 'buttons'));
    }

    public function delete(int $id): \Illuminate\Http\RedirectResponse {// удаление записи (для админа)
        \App\Post::destroy($id);
        return redirect('/user/posts');

    }

    public function editForm(int $id): \Illuminate\View\View {//получение формы редактирования записи (для админа)
        $post = \App\Post::find($id);
        $id = Auth::id();
        return view('posts.editForm', compact('post', 'id')) ;
    }


    public function edit(Request $request): \Illuminate\Http\RedirectResponse {// запись отредактированой записи в БД (для админа)

        $request->validate([
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
        return redirect('/user/posts');
    }


}
