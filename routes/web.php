<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/posts', 'PostController@AllPosts');
Route::get('/posts/{id}', 'PostController@PostById');


Route::get('/', function () {
    return view('welcome');
});
