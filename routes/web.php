<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\TodoController;
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


Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/','/login');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('todos', TodoController::class);
Route::get('users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users.index');
Route::get('fetchtodos', [App\Http\Controllers\TodoController::class, 'fetchtodos'])->name('fetchtodos');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('users/{user}/todos', [App\Http\Controllers\Admin\UserTodoController::class, 'index'])->name('users.todos.index');
Route::delete('user/todos/{todo}/delete', [App\Http\Controllers\Admin\UserTodoController::class, 'destroy'])->name('users.todos.destroy');
