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

Route::prefix('user')->middleware('auth')->group( function () {
    Route::get('', function () {
        return redirect()->route('user.posts');
    });
    Route::get('posts/new', 'PostController@createForm')->name('user.new');
    Route::post('posts/new', 'PostController@create');
    Route::get('posts', 'PostController@allUser')->name('user.posts');
    Route::get('posts/unset/{id}', 'PostController@delete')->name('user.unset');
    Route::get('posts/edit/{id?}', 'PostController@editForm')->name('user.edit');
    Route::post('posts/edit', 'PostController@edit');
});

Route::get('/posts', 'PostController@all');
Route::get('/posts/{id}', 'PostController@byId')->name('all.post');

//5 енд поинтов для операций все, 1, создание, редактирование, удаление
//удалить posts из методов, уточнить тип объекта, изменить unset на delete, изменить admin на пользователя



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
