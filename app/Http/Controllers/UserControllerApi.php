<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserControllerApi extends Controller
{
    public function index(): JsonResponse
    {
        $model = \App\User::all();

        if (!count($model)) {
            return $this->jsonResponse('Not found users', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function store(Request $request): JsonResponse
    {

        $validator = Validator::make($request->post(), [
            'name' => ['bail', 'required', 'max:191', 'string',],
            'email' => ['bail', 'required', 'max:191', 'string', 'email', 'unique:users',],
            'password' => ['bail', 'required', 'min:6', 'string',],
            'api_token' => ['bail', 'required', 'size:60', 'string', 'unique:users',],
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors(), 400);
        }

        $model = new \App\User;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = $request->password;
        $model->api_token = $request->api_token;
        $model->save();
        return $this->jsonResponse(['User successfully added', $model->getAttributes()], 201);

    }

    public function show($id): JsonResponse
    {

        $model = \App\User::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found user', 400);
        }
        return $this->jsonResponse($model, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $model = \App\User::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found user', 400);
        }

        $validator = Validator::make($request->post(), [
            'name' => ['bail', 'string', 'max:191',],
            'email' => ['bail', 'string', 'max:191', 'email', 'unique:users',],
            'api_token' => ['bail', 'string', 'size:60', 'unique:users',],
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse($validator->errors());
        }

        $model->name = $request->post('name') ?? $model->name;
        $model->email = $request->post('email') ?? $model->email;
        $model->api_token = $request->post('api_token') ?? $model->api_token;

        $model->save();
        return $this->jsonResponse(['User successfully updated', $model->getAttributes()], 201);

    }

    public function destroy($id): JsonResponse
    {
        $model = \App\User::find($id);
        if (empty($model)) {
            return $this->jsonResponse('Not found user', 400);
        }

        $model = \App\User::destroy($id);
        if ($model === 0) {
            return $this->jsonResponse('Unknown error', 400);
        }
        return $this->jsonResponse('User successfully deleted', 201);

    }


}
