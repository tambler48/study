<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Post;
use App\User;
use Gate;
use Lang;

class PostController extends Controller
{

    protected $routePrefix = 'user';

    public function all(): \Illuminate\View\View
    {
        $data = Post::all();
        $title = Lang::get('messagesPost.title_list');
        $routePrefix = 'all';
        $alert = Session::pull('alert');
        return view('posts.block', compact('data', 'title', 'routePrefix', 'alert'));
    }

    public function index(): \Illuminate\View\View
    {
        $data = Post::all();
        $user = Auth::user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $title = Lang::get('messagesPost.title_list');
        $routePrefix = $this->routePrefix;
        return view('posts.block', compact('data', 'title', 'routePrefix', 'user_id', 'user_role'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Illuminate\View\View
     */
    public function createForm(): object
    {
        if (Gate::denies('create', new Post)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_create')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }
        $id = Auth::id();
        $title = Lang::get('messagesPost.title_create');
        $routePrefix = $this->routePrefix;
        return view('posts.createForm', compact('id', 'title', 'routePrefix'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $post = $this->trim($request->post());
        $model = new Post;

        if (Gate::denies('create', $model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messages.not_create')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }

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
            $model->save();
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Illuminate\View\View
     */
    public function show(int $id): object
    {
        $comments = new \App\Http\Controllers\CommentController;
        $comments = $comments->get($id);

        $data = Post::find($id);
        if (!empty($data)) {
            return view('posts.post', compact('data', 'comments'));
        }
        Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found')]]);
        $prefix = Auth::id() === NULL ? 'all' : $this->routePrefix;
        return redirect()->route($prefix . '.posts');

    }

    public function editForm(int $id): object
    {
        $post = Post::find($id);
        if (empty($post)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found')]]);
            return redirect()->route($this->routePrefix . '.posts');
        } elseif (Gate::denies('update', $post)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_update')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }

        $id = Auth::id();
        $title = Lang::get('messagesPost.title_edit');
        $routePrefix = $this->routePrefix;
        return view('posts.editForm', compact('post', 'id', 'title', 'routePrefix'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $model = new Post;
        $model = $model->find($id);
        if (empty($model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }
        if (Gate::denies('update', $model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_update')]]);
            return redirect()->route($this->routePrefix . '.posts');
        }

        $post = $this->trim($request->post());
        $model->addPost($post);
        $result = $model->validate();
        if (count($result)) {
            Session::flash('alert', $result);
            return redirect()->route($this->routePrefix . '.posts');
        }

        $model->save();
        return redirect()->route($this->routePrefix . '.posts');
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $model = Post::find($id);
        if (empty($model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_found')]]);
        } elseif (Gate::denies('destroy', $model)) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.not_delete')]]);
        } else {
            $model = Post::destroy($id);
        }
        if ($model === 0) {
            Session::flash('alert', [Lang::get('messagesPost.warning') => [Lang::get('messagesPost.unknown')]]);
        }
        return redirect()->route($this->routePrefix . '.posts');
    }

}
