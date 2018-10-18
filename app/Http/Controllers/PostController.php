<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function AllPosts()
    {
        $posts = \App\Post::all(['header']);
        return view('study.posts', compact('posts'));
    }

    public function PostById($id){
        $post = \App\Post::find($id);
        return view('study.post', compact('post')) ;
    }
}
