<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function all_posts(){
        $posts = \App\Post::all(['header']);
        return view('study.posts', compact('posts'));
    }

    public function post_by_id($id){
        $post = \App\Post::find($id);
        return view('study.post', compact('post')) ;
    }
}
