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
        Route::get('/teacher/work', [TeacherController::class, 'work']);
        Route::get('/teacher/work/{id}', [TeacherController::class, 'work_detail']);
        Route::post('/teacher/work/create', [TeacherController::class, 'work_store']);
        Route::post('/teacher/work/update/{id}', [TeacherController::class, 'work_update']);
        Route::post('/teacher/work/delete/{id}', [TeacherController::class, 'work_delete']);
        Route::get('/teacher/students', [TeacherController::class, 'students']);
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