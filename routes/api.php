<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum;

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/dashboard', 'App\Http\Controllers\Admin\AdminController@dashboard');
Route::post('/login', 'App\Http\Controllers\Admin\AdminController@login');
Route::post('/user_login', 'App\Http\Controllers\User\UserController@login');

Route::get('/post', 'App\Http\Controllers\Admin\PostController@index');
Route::get('/create_post', 'App\Http\Controllers\Admin\PostController@create');
Route::post('/createPost', 'App\Http\Controllers\Admin\PostController@createPost');
Route::post('/createCategory', 'App\Http\Controllers\Admin\PostController@createCategory');
Route::post('/createComment', 'App\Http\Controllers\Admin\PostController@createReply');
Route::post('/createAssociation', 'App\Http\Controllers\Admin\PostController@createAssociation');
Route::post('/createShare', 'App\Http\Controllers\Admin\PostController@createShare');
Route::post('/createReplyComment', 'App\Http\Controllers\Admin\PostController@createReplyComment');

Route::get('/users', 'App\Http\Controllers\Admin\UserController@index');
Route::get('/create_user', 'App\Http\Controllers\Admin\UserController@index');
Route::post('/createUser', 'App\Http\Controllers\Admin\UserController@store');

Route::get('/admins', 'App\Http\Controllers\Admin\AdminController@index');
Route::get('/create_admin', 'App\Http\Controllers\Admin\AdminController@index');
Route::post('/createAdmin', 'App\Http\Controllers\Admin\AdminController@store');

Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@index');
Route::get('/createAdmin', 'App\Http\Controllers\Admin\AdminController@index');
Route::get('/create_admin', 'App\Http\Controllers\Admin\AdminController@index');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user_logout', 'App\Http\Controllers\User\UserController@logout');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', 'App\Http\Controllers\Admin\AdminController@logout');
});

