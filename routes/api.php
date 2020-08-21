<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', 'UsersController@getMe');

    Route::post('/projects', 'ProjectsController@createProject');

    Route::post('/projects/{project_id}/products', 'ProductsController@createProduct');

});

Route::post('/register', 'UsersController@registerUser');

//Users
Route::get('/user/{user_id}', 'UsersController@getUser');
Route::get('/users', 'UsersController@getUsers');

//Search
Route::get('/search/projects', 'ProjectsController@searchProject');
Route::get('/search/users', 'UsersController@searchUsers');

//Projects
Route::get('/project/{project_id}', 'ProjectsController@getProject');

//Products
Route::get('/product/{product_id}', 'ProductsController@getProduct');
