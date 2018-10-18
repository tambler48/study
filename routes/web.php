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

Route::prefix('admin')->group(function () {
    Route::get('new', 'PostController@CreateFormPost');
    Route::post('new', 'PostController@CreatePost');
    Route::get('posts', 'PostController@AllPostsAdmin');
    Route::get('posts/unset/{id}', 'PostController@UnsetPost');
    Route::get('posts/edit/{id}', 'PostController@EditFormPost');
    Route::post('posts/edit', 'PostController@EditPost');

});

Route::get('/posts', 'PostController@AllPosts');
Route::get('/posts/{id}', 'PostController@PostById');





Route::get('/', function () {
    return view('welcome');
});
