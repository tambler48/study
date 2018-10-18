<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function AllPosts()
    {
        $posts = \App\Post::all();     //получение всех записей (для всех)
        return view('study.posts', compact('posts'));
    }

    public function PostById($id){      //получение записи по id (для всех)
        $post = \App\Post::find($id);
        if (empty($post)) abort(404);
        return view('study.post', compact('post')) ;
    }

    public function CreateFormPost(){   //получение формы создания записи (для админа)
            $id = 1; //TODO получить id пользователя и проверить на admin
            return view('study.CreateForm', compact('id'));
    }

    public function CreatePost(Request $request){   // запись новой записи в БД (для админа)

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

    public function AllPostsAdmin() //получение всех записей с дополнительными кнопками (для админа) TODO: изменить метод только для админа
    {
        $posts = \App\Post::all();
        $buttons = true;
        return view('study.posts', compact('posts', 'buttons'));
    }

    public function UnsetPost($id) // удаление записи (для админа) TODO: добавить проверку на админку
    {
        \App\Post::destroy($id);
        return redirect('/admin/posts');

    }

    public function EditFormPost($id) //получение формы редактирования записи (для админа) TODO: добавить проверку на админку и получение id
    {
        $post = \App\Post::find($id);
        $user = 1;
        return view('study.EditForm', compact('post', 'user')) ;

    }


    public function EditPost(Request $request) // запись отредактированой записи в БД (для админа) TODO: добавить проверку на админку
    {

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
