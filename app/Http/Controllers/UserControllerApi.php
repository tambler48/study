<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User;

class UserControllerApi extends Controller
{
    public function index(): JsonResponse
    {
        $model = User::all();

        if (!count($model)) {
            return $this->jsonResponse('Not found users', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $user = new User();

        $validateResult = $user->validator($request->post(), 0, [
            'name' => ['required',],
            'email' => ['required',],
            'password' => ['required',],
        ])->errors()->messages();

        if(count($validateResult)){
            return $this->jsonResponse($validateResult, 400);
        }
        $userParams = $this->trim($request->post());
        $user->addModel($userParams);
        $user->save();
        return $this->jsonResponse(['User successfully added', $user->getAttributes()], 201);
    }

    public function show(int $id): JsonResponse
    {

        $model = User::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found user', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);
        if (empty($user)) {
            return $this->jsonResponse('Not found user', 400);
        }

        $validateResult = $user->validator($request->post())->errors()->messages();
        if(count($validateResult)){
            return $this->jsonResponse($validateResult, 400);
        }
        $userParams = $this->trim($request->post());
        $user->addModel($userParams);
        $user->save();
        return $this->jsonResponse(['User successfully updated', $user->getAttributes()], 201);

    }

    public function destroy(int $id): JsonResponse
    {
        $user = User::find($id);
        if (empty($user)) {
            return $this->jsonResponse('Not found user', 400);
        }

        $user = User::destroy($id);
        if ($user === 0) {
            return $this->jsonResponse('Unknown error', 400);
        }
        return $this->jsonResponse('User successfully deleted', 201);

    }


}
