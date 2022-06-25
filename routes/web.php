<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login',[AuthController::class,'login']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('home');
    });
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register',[AuthController::class,'register']);