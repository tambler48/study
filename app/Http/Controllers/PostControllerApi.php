<?php

namespace App\Http\Controllers;

use App\Traits\PostTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostControllerApi extends Controller
{

    use PostTrait;

    public function index(): JsonResponse
    {

        [$data, $code] = static::takeAll();
        if ($code === 200) {
            return $this->jsonResponse($data, 200);
        }
        return $this->jsonResponse('Not found posts', 400);
    }

    public function store(Request $request): JsonResponse
    {

        [$data, $code] = static::create($request);
        if ($code === 201) {
            return $this->jsonResponse(['Post successfully added', $data], 201);
        }
        return $this->jsonResponse($data, 400);

    }

    public function show($id): JsonResponse
    {

        [$data, $code] = static::byId($id);
        if ($code === 200) {
            return $this->jsonResponse($data, 200);
        }
        return $this->jsonResponse('Not found post', 400);

    }

    public function update(Request $request, $id): JsonResponse
    {

        [$data, $code] = $this->edit($request, $id);
        if ($code === 201) {
            return $this->jsonResponse(['Post successfully updated', $data], 201);
        }
        return $this->jsonResponse($data, 400);

    }

    public function destroy(int $id): JsonResponse
    {

        [$data, $code] = $this->delete($id);
        if ($code === 201) {
            return $this->jsonResponse($data, 201);
        }
        return $this->jsonResponse($data, 400);
    }

}
