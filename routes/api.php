<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::prefix('auth')->group(function () {
Route::get('login', 'App\Http\Controllers\AuthController@login');
    Route::get('register', 'App\Http\Controllers\AuthController@register');
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });


});

