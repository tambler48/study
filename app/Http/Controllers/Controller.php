<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $trimKeys = ['_token', 'post_id', '_method'];

    protected function jsonResponse($ans, $code = 400): JsonResponse
    {
        return new JsonResponse($ans, $code, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    protected function trim(array $data): array
    {

        $data = array_filter($data);
        foreach ($this->trimKeys as $key => $value){
            if (isset($data[$value])){
                unset($data[$value]);
            }
        }
        return $data;
    }

}
