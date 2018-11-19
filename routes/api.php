<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('register', 'Auth\Api\RegisterController@regist');
Route::post('login', 'Auth\Api\LoginController@login');
Route::post('logout', 'Auth\Api\LoginController@logout');

Route::resource('posts', 'PostControllerApi')->middleware('auth:api');
Route::resource('users', 'UserControllerApi')->middleware('auth:api');
Route::get('users/{manage}/remove', 'UserControllerApi@remove')->middleware('auth:api')/*->name('users.remove')*/;
Route::get('users/{manage}/restore', 'UserControllerApi@restore')->middleware('auth:api')/*->name('users.restore')*/;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
