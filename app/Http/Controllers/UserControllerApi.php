<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;
use Gate;
use Lang;

class UserControllerApi extends Controller
{
    public function index(): JsonResponse
    {
        if (Gate::denies('view', new User)) {
            return $this->jsonResponse('', 403);
        }
        $model = User::all();
        if (!count($model)) {
            return $this->jsonResponse('', 404);
        }
        return $this->jsonResponse($model, 200);
    }

    public function store(Request $request): JsonResponse
    {
        if (Gate::denies('create', new User)) {
            return $this->jsonResponse('', 403);
        }
        $user = new User();
        $validateResult = $user->validator($request->post(), 0, [
            'name' => ['required',],
            'email' => ['required',],
            'password' => ['required',],
        ])->errors()->messages();

        if (count($validateResult)) {
            return $this->jsonResponse($validateResult, 406);
        }
        $userParams = $this->trim($request->post());
        $user->addModel($userParams);
        $user->save();
        return $this->jsonResponse( $user->getAttributes(), 201);
    }

    public function show(int $id): JsonResponse
    {
        if (Gate::denies('view', new User)) {
            return $this->jsonResponse('', 403);
        }
        $model = User::find($id);
        if (empty($model)) {
            return $this->jsonResponse('', 404);
        }
        return $this->jsonResponse($model, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        if (Gate::denies('update', new User)) {
            return $this->jsonResponse('', 403);
        }
        $user = User::find($id);
        if (empty($user)) {
            return $this->jsonResponse('', 404);
        }

        $validateResult = $user->validator($request->post())->errors()->messages();
        if (count($validateResult)) {
            return $this->jsonResponse($validateResult, 406);
        }
        $userParams = $this->trim($request->post());
        $user->addModel($userParams);
        $user->save();
        return $this->jsonResponse( $user->getAttributes(), 201);

    }

    public function destroy(int $id): JsonResponse
    {
        if (Gate::denies('destroy', new User)) {
            return $this->jsonResponse('', 403);
        }
        $user = User::find($id);
        if (empty($user)) {
            return $this->jsonResponse('', 404);
        }

        $user = User::destroy($id);
        if ($user === 0) {
            return $this->jsonResponse('', 418);
        }
        return $this->jsonResponse('', 204);

    }


    public function remove(int $id): JsonResponse
    {
        $user = User::find($id);
        if (empty($user)) {
            return $this->jsonResponse('', 404);
        }

        if (Gate::denies('remove', $user)) {
            return $this->jsonResponse('', 403);
        }

        $user->active = false;
        $user->timestamps = false;
        $user->save();

        return $this->jsonResponse('', 204);

    }

    public function restore(int $id): JsonResponse
    {
        $user = User::find($id);
        if (empty($user)) {
            return $this->jsonResponse('', 404);
        }

        if (Gate::denies('restore', $user)) {
            return $this->jsonResponse('', 403);
        }

        $user->active = true;
        $user->timestamps = false;
        $user->save();

        return $this->jsonResponse('', 200);
    }

}
