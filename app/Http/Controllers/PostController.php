<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Post;

class PostController extends Controller
{

    protected $routePrefix = 'user';

    public function all(): \Illuminate\View\View
    {
        $data = Post::all();
        $title = 'Все записи';
        $routePrefix = 'all';
        $alert = Session::pull('alert');
        return view('posts.block', compact('data', 'title', 'routePrefix', 'alert'));
    }

    public function index(): \Illuminate\View\View
    {

        $data = Post::all();
        $buttons = true;
        $title = 'Все записи';
        $routePrefix = $this->routePrefix;
        $alert = Session::pull('alert');
        return view('posts.block', compact('data', 'buttons', 'title', 'routePrefix', 'alert'));
    }

    public function createForm(): \Illuminate\View\View
    {

        $id = Auth::id();
        $title = 'Создание записи';
        $routePrefix = $this->routePrefix;
        return view('posts.createForm', compact('id', 'title', 'routePrefix'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        $post = $this->trim($request->post());

        $model = new Post;
        $model->addPost($post);
        $model->addValidate([
            'user_id' => ['required',],
            'header' => ['required',],
            'body' => ['required',],
        ]);
        $result = $model->validate();
        if (count($result)) {
            Session::flash('alert', $result);
        } else {
            $model->timestamps = false;
            $model->save();
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

    public function show(int $id): object
    {

        $data = Post::find($id);
        if (!empty($data)) {
            return view('posts.post', compact('data'));
        }
        Session::flash('alert', ['Alert' => ['Not found post']]);
        $prefix = Auth::id() === NULL ? 'all' : $this->routePrefix;
        return redirect()->route($prefix . '.posts');

    }

    public function editForm(int $id): \Illuminate\View\View
    {

        $post = Post::find($id);
        $id = Auth::id();
        $title = 'Редактирование записи';
        $routePrefix = $this->routePrefix;
        return view('posts.editForm', compact('post', 'id', 'title', 'routePrefix'));
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {

        $model = new Post;
        $model = $model->find($request->get('post_id'));
        if (empty($model)) {
            Session::flash('alert', ['Alert' => ['Not found post']]);
        } else {
            $post = $this->trim($request->post());
            $model->addPost($post);
            $result = $model->validate();
            if (count($result)) {
                Session::flash('alert', $result);
            } else {
                $model->timestamps = false;
                $model->save();
            }
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {

        $model = Post::find($id);
        if (empty($model)) {
            Session::flash('alert', ['Alert' => ['Not found post']]);
        } else {
            $model = Post::destroy($id);
        }
        if ($model === 0) {
            Session::flash('alert', ['Alert' => ['Unknown error']]);
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

}
