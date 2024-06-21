<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/diasFestivos', [HomeController::class, 'diasFestivos'])->name('home');

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');

Route::get('/usuarios/data', [UserController::class, 'data'])->name('usuarios.data');

Route::post('/usuarios/create', [UserController::class, 'createUser'])->name('usuarios.create');

Route::delete('/usuarios/{id}', [UserController::class, 'deleteUser'])->name('usuarios.delete');

Route::put('/usuarios/{id}', [UserController::class, 'updateUser'])->name('usuarios.update');