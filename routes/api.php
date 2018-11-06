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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
