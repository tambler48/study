<?php

namespace App\Http\Controllers;

use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    use PostTrait;

    protected $routePrefix = 'user';

    public function all(): \Illuminate\View\View
    {

        [$data, $code] = static::takeAll();
        $title = 'Все записи';
        $routePrefix = $this->routePrefix;
        return view('posts.block', compact('data', 'title', 'routePrefix'));
    }

    public function index(): \Illuminate\View\View
    {

        [$data, $code] = static::takeAll();
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

        [$data, $code] = static::create($request);
        if ($code !== 201) {
            Session::flash('alert', $data);
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

    public function show(int $id): \Illuminate\View\View
    {

        [$data, $code] = static::byId($id);
        if ($code !== 200) {
            Session::flash('alert', $data);
        }
        return view('posts.post', compact('data'));
    }

    public function editForm(int $id): \Illuminate\View\View
    {

        $post = \App\Post::find($id);
        $id = Auth::id();
        $title = 'Редактирование записи';
        $routePrefix = $this->routePrefix;
        return view('posts.editForm', compact('post', 'id', 'title', 'routePrefix'));
    }


    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {

        [$data, $code] = $this->edit($request, $request->get('post_id'));
        if ($code !== 201) {
            Session::flash('alert', $data);
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {

        [$data, $code] = $this->delete($id);
        if ($code !== 201) {
            Session::flash('alert', $data);
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

}
