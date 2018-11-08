<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Gate;
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
        if (Gate::denies('look', new User)) {
            Session::flash('alert', ['warning' => ['You can not see users.']]);
            return redirect()->back();
        }
        $data = User::all();
        $title = 'Список пользователей';
        $routePrefix = $this->routePrefix;
        return view($routePrefix . '.block', compact('data', 'title', 'routePrefix'));
    }

    /**
     * @return \Illuminate\View\View|Illuminate\Http\RedirectResponse
     */
    public function create(): object
    {
        if (Gate::denies('create', new User)) {
            Session::flash('alert', ['warning' => ['You can not create users.']]);
            return redirect()->back();
        }
        $routePrefix = $this->routePrefix;
        $roles = Role::getRoles();
        return view('auth.register', compact('routePrefix', 'roles'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('create', new User)) {
            Session::flash('alert', ['warning' => ['You can not create users.']]);
            return redirect()->back();
        }
        $user = new User();
        $userData = $user->validator($request->post(), 0, [
            'name' => ['required',],
            'email' => ['required',],
            'password' => ['required',],
            'role_id' => ['required',],
        ])->validate();

        $user->addModel($userData);
        $user->save();
        return redirect()->route($this->routePrefix . '.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Illuminate\View\View
     */
    public function show(int $id): object
    {
        if (Gate::denies('look', new User)) {
            Session::flash('alert', ['warning' => ['You can not see users.']]);
            return redirect()->back();
        }
        $data = User::find($id);
        if (!empty($data)) {
            return view('manage.user', compact('data'));
        }
        Session::flash('alert', ['Alert' => ['Not found user']]);
        $prefix = $this->routePrefix;
        return redirect()->route($prefix . '.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Illuminate\View\View
     */
    public function edit(int $id): object
    {
        if (Gate::denies('update', new User)) {
            Session::flash('alert', ['warning' => ['You can not update users.']]);
            return redirect()->back();
        }
        $user = User::find($id);
        if (empty($user)) {
            Session::flash('alert', ['warning' => ['Not found user.']]);
            return redirect()->route($this->routePrefix . '.posts');
        }
        $routePrefix = $this->routePrefix;
        $roles = Role::getRoles();
        return view('manage.editUser', compact('routePrefix', 'roles', 'user'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('update', new User)) {
            Session::flash('alert', ['warning' => ['You can not update users.']]);
            return redirect()->back();
        }
        $user = new User();
        $user = $user->find($id);
        if (empty($user)) {
            Session::flash('alert', ['Alert' => ['Not found user.']]);
            return redirect()->route($this->routePrefix . '.index');
        }
        $params = $this->trim($request->post());
        $params = $user->validator($params, $id)->validate();
        $user->addModel($params);
        $user->timestamps = false;
        $user->save();
        return redirect()->route($this->routePrefix . '.index');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        if (Gate::denies('destroy', new User)) {
            Session::flash('alert', ['warning' => ['You can not destroy users.']]);
            return redirect()->back();
        }
        $user = User::find($id);
        if (empty($user)) {
            Session::flash('alert', ['Alert' => ['Not found post']]);
            return redirect()->route($this->routePrefix . '.index');
        }
        $user = User::destroy($id);
        if ($user === 0) {
            Session::flash('alert', ['Alert' => ['Unknown error']]);
        }
        return redirect()->route($this->routePrefix . '.index');
    }
}
