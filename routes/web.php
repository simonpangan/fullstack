<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invoice', function () {
    return view('invoice');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('{path}',[App\Http\Controllers\HomeController::class, 'index'])->where( 'path', '([A-z\/_.\d-]+)?' );