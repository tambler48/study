<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Gate;
use Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    protected $routePrefix = 'manage';

    /**
     * @return \Illuminate\View\View|Illuminate\Http\RedirectResponse
     */
    public function index(): object
    {
        if (Gate::denies('view', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_view')]]);
            return redirect()->back();
        }
        $data = User::all();
        $title = Lang::get('messagesUser.title_list');
        $routePrefix = $this->routePrefix;
        return view($routePrefix . '.block', compact('data', 'title', 'routePrefix'));
    }

    /**
     * @return \Illuminate\View\View|Illuminate\Http\RedirectResponse
     */
    public function create(): object
    {
        if (Gate::denies('create', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_create')]]);
            return redirect()->back();
        }
        $routePrefix = $this->routePrefix;
        $roles = Role::getRoles();
        $title = Lang::get('messagesUser.title_create');
        return view('auth.register', compact('routePrefix', 'roles', 'title'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('create', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_create')]]);
            return redirect()->back();
        }

        $user = new User();
        $params = $this->trim($request->post());
        $user->addModel($params);
        $errors = $user->validate();
        if (count($errors)) {
            return redirect()->back();
        }
        $user->password = Hash::make($user->password);
        $user->__unset('password_confirmation');

        $user->save();
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Illuminate\View\View
     */
    public function show(int $id): object
    {
        if (Gate::denies('view', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_view')]]);
            return redirect()->back();
        }

        $data = User::find($id);
        if (!empty($data)) {
            return view('manage.user', compact('data'));
        }
        Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_found')]]);
        $prefix = $this->routePrefix;
        return redirect()->route($prefix . '.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Illuminate\View\View
     */
    public function edit(int $id): object
    {
        if (Gate::denies('update', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_update')]]);
            return redirect()->back();
        }
        $user = User::find($id);
        if (empty($user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_found')]]);
            return redirect()->route($this->routePrefix . '.index');
        }
        $routePrefix = $this->routePrefix;
        $roles = Role::getRoles();
        $title = Lang::get('messagesUser.title_edit');
        return view('manage.editUser', compact('routePrefix', 'roles', 'user', 'title'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('update', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_update')]]);
            return redirect()->back();
        }
        $user = new User();
        $user = $user->find($id);
        if (empty($user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_found')]]);
            return redirect()->route($this->routePrefix . '.index');
        }
        $params = $this->trim($request->post());
        $user->addModel($params);
        $errors = $user->validate($id);
        if (count($errors)) {
            return redirect()->back();
        }
        $user->password = Hash::make($user->password);
        $user->__unset('password_confirmation');
        $user->save();
        return redirect()->route($this->routePrefix . '.index');
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('destroy', new User)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_delete')]]);
            return redirect()->back();
        }
        $user = User::find($id);
        if (empty($user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_found')]]);
            return redirect()->route($this->routePrefix . '.index');
        }
        $user = User::destroy($id);
        if ($user === 0) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.unknown')]]);
        }
        return redirect()->route($this->routePrefix . '.index');
    }

    public function remove(int $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        if (empty($user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_found')]]);
            return redirect()->route($this->routePrefix . '.index');
        }

        if (Gate::denies('remove', $user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_remove')]]);
            return redirect()->back();
        }

        $user->active = false;
        $user->timestamps = false;
        $user->save();

        return redirect()->route($this->routePrefix . '.index');

    }

    public function restore(int $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);
        if (empty($user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_found')]]);
            return redirect()->route($this->routePrefix . '.index');
        }

        if (Gate::denies('restore', $user)) {
            Session::flash('alert', [Lang::get('messagesUser.warning') => [Lang::get('messagesUser.not_restore')]]);
            return redirect()->back();
        }

        $user->active = true;
        $user->timestamps = false;
        $user->save();

        return redirect()->route($this->routePrefix . '.index');

    }

}
