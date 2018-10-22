<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = \App\Post::all();
        return response()->json($posts, 201, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'header' => 'bail|required|max:255',
            'body' => 'required',
        ]);

        $model = new \App\Post;
        $model->user_id = $request->user_id;
        $model->header = $request->header;
        $model->body = $request->body;
        $model->timestamps = false;
        $model->save();
        return response()->json('OK', 201, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = \App\Post::find($id);
        if (empty($post)) {
            abort(404);
        }
        return response()->json($post, 201, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'exists:users,id',
            'post_id' => 'exists:posts,id',
            'header' => 'bail|required|max:255',
            'body' => 'required',
        ]);

        $model = \App\Post::find($id);
        $model->user_id = $request->user_id;
        $model->header = $request->header;
        $model->body = $request->body;
        $model->timestamps = false;
        $model->save();
        return response()->json('OK', 201, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Post::destroy($id);
        return response()->json('OK', 201, ['Content-Type' => 'application/json; charset=UTF-8']);
    }
}
