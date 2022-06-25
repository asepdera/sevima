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
    Route::group(['middleware' => 'is_teacher:teacher', 'prefix' => 'teacher'], function () {
        Route::get('/', [TeacherController::class, 'dashboard']);
        Route::get('/soal', [TeacherController::class, 'soal']);
        Route::get('/soal/{id}', [TeacherController::class, 'soal_detail']);
        Route::post('/soal/create', [TeacherController::class, 'soal_store']);
        Route::post('/soal/update/{id}', [TeacherController::class, 'soal_update']);
        Route::post('/soal/delete/{id}', [TeacherController::class, 'soal_delete']);
        Route::get('/students', [TeacherController::class, 'students']);
        Route::get('/kelas', [TeacherController::class, 'kelas']);
        Route::post('/kelas/add', [TeacherController::class, 'add_kelas']);
        Route::post('/kelas/update/', [TeacherController::class, 'update_kelas']);
        Route::get('/kelas/edit/{id}', [TeacherController::class, 'edit_kelas']);
        Route::delete('/kelas/delete/{id}', [TeacherController::class, 'delete_kelas']);
    });
    Route::group(['middleware' => 'is_teacher:student', 'prefix' => 'student'], function () {
        Route::get('/', [StudentsController::class, 'dashboard']);
    });
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register_action',[AuthController::class,'register']);
Route::get('/logout',[AuthController::class,'logout']);