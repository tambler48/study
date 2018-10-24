<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $arr = \App\User::all();
        return response()->json($arr, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['bail','required','string','max:191',],
            'email' => ['bail','required','string','email','unique:users','max:191',],
            'password' => ['bail','required','string','min:6',],
            'api_token' => ['bail','required','string','size:60',],
        ]);

        $model = new \App\User;
        $model->name = $request->name;
        $model->email = $request->email;
        $model->password = $request->password;
        $model->api_token = $request->api_token;
        $model->save();
        return response()->json('OK', 201, ['Content-Type' => 'application/json; charset=UTF-8']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $arr = \App\User::find($id);
        if (empty($arr)) {
            abort(404);
        }
        return response()->json($arr, 200, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        $request->validate([
            'name' => ['bail','string','max:191',],
            'email' => ['bail','string','email','unique:users','max:191',],
            'api_token' => ['bail','string','size:60',],
        ]);

        $model = \App\User::find($id);
        $model->name = $request->name;
        $model->email = $request->email;
        $model->api_token = $request->api_token;
        $model->save();
        return response()->json('OK', 200, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        \App\User::destroy($id);
        return response()->json('OK', 200, ['Content-Type' => 'application/json; charset=UTF-8']);
    }
}
