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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});
use App\Http\Controllers\API\UserController;

Route::group(['middleware' => ['auth:api','admin']], function() {
    Route::apiResource('user', UserController::class);
    Route::get('profile',[UserController::class, 'profile']);
    Route::get('findUser',[UserController::class, 'search']);
    Route::put('profile',[UserController::class, 'updateProfile']);
});


    
