<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentsController;

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

Route::post('/login_action',[AuthController::class,'login']);
Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'is_teacher:teacher'], function () {
        Route::get('/teacher', [TeacherController::class, 'dashboard']);
    });
    Route::group(['middleware' => 'is_teacher:student'], function () {
        Route::get('/student', [StudentsController::class, 'dashboard']);
    });
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register_action',[AuthController::class,'register']);
Route::get('/logout',[AuthController::class,'logout']);