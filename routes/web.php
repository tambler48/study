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

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('', function () {
        return redirect()->route('user.posts');
    });
    Route::get('posts/new', 'PostController@createForm')->name('user.new');
    Route::post('posts/new', 'PostController@store');
    Route::get('posts', 'PostController@index')->name('user.posts');
    Route::get('posts/{id}', 'PostController@show')->name('user.post');
    Route::get('posts/unset/{id}', 'PostController@destroy')->name('user.unset');
    Route::get('posts/edit/{id?}', 'PostController@editForm')->name('user.edit');
    Route::post('posts/edit/{id}', 'PostController@update');

    Route::resource('manage', 'UserController');
    Route::get('manage/{manage}/remove', 'UserController@remove')->name('manage.remove');
    Route::get('manage/{manage}/restore', 'UserController@restore')->name('manage.restore');

    Route::post('posts/comments', 'CommentController@store')->name('comment.store');
    Route::delete('posts/comments/{id}', 'CommentController@destroy')->name('comment.destroy');
    Route::get('posts/comments/{id}', 'CommentController@edit')->name('comment.edit');
    Route::put('posts/comments/{id}', 'CommentController@update')->name('comment.update');

});


Route::get('/posts', 'PostController@all')->name('all.posts');
Route::get('/posts/{id}', 'PostController@show')->name('all.post');

Route::get('setlocale/{name}', function (string $name) {
    $response = redirect()->back();
    $locales = \Config::get('app.locales');
    if (in_array($name, $locales, true)) {
        $response->cookie(Cookie::forever('locale', $name));
    }
    return $response;
})->name('setlocale');


Route::get('/', function () {
    return view('welcome');
})->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
