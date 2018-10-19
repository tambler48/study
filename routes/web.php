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

Route::prefix('admin')->middleware('auth')->group( function () {
    Route::get('', function () {
        return redirect()->route('admin.posts');
    });
    Route::get('posts/new', 'PostController@createFormPost')->name('admin.new');
    Route::post('posts/new', 'PostController@createPost');
    Route::get('posts', 'PostController@allPostsAdmin')->name('admin.posts');
    Route::get('posts/unset/{id}', 'PostController@unsetPost')->name('admin.unset');
    Route::get('posts/edit/{id?}', 'PostController@editFormPost')->name('admin.edit');
    Route::post('posts/edit', 'PostController@editPost');

});

Route::get('/posts', 'PostController@allPosts');
Route::get('/posts/{id}', 'PostController@postById')->name('all.post');





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
