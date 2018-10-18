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
    Route::get('', function () {
        return redirect()->route('admin.posts');
    });
    Route::get('posts/new', 'PostController@CreateFormPost')->name('admin.new');
    Route::post('posts/new', 'PostController@CreatePost');
    Route::get('posts', 'PostController@AllPostsAdmin')->name('admin.posts');
    Route::get('posts/unset/{id}', 'PostController@UnsetPost')->name('admin.unset');
    Route::get('posts/edit/{id?}', 'PostController@EditFormPost')->name('admin.edit');
    Route::post('posts/edit', 'PostController@EditPost');

});

Route::get('/posts', 'PostController@AllPosts');
Route::get('/posts/{id}', 'PostController@PostById')->name('all.post');





Route::get('/', function () {
    return view('welcome');
});
