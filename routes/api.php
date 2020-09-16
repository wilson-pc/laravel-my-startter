<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::middleware('api')->get('/user', function () {
    return "animedia";
});

Route::middleware('auth:api')->resource('products', ProductController::class);

Route::middleware('api')->resource('blogs', BlogController::class);
//Route::middleware('auth:api')->resource('users', UserController::class);
//Route::middleware('api')->post('auth/login', 'UserController@login');

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('users', [UserController::class, 'index']);


});

Route::group(['middleware' => 'api'], function () {
    Route::post('auth/login', [UserController::class, 'login']);
    Route::post('users', [UserController::class, 'store']);

});