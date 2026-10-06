<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TrilhasController;
use App\Http\Controllers\ConteudosController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::get('/trilhas', [TrilhasController::class, 'index'])->name('trilhas.index');
Route::get('/trilhas/create', [TrilhasController::class, 'create'])->name('trilhas.create');
Route::get('/trilhas/{trilha}', [TrilhasController::class, 'show'])->name('trilhas.show');
Route::get('/trilhas/{trilha}/edit', [TrilhasController::class, 'edit'])->name('trilhas.edit');
Route::post('/trilhas', [TrilhasController::class, 'store'])->name('trilhas.store');
Route::put('/trilhas/{trilha}', [TrilhasController::class, 'update'])->name('trilhas.update');
Route::delete('/trilhas/{trilha}', [TrilhasController::class, 'destroy'])->name('trilhas.destroy');

Route::get('/conteudos', [ConteudosController::class, 'index'])->name('conteudos.index');
Route::get('/conteudos/create', [ConteudosController::class, 'create'])->name('conteudos.create');
Route::get('/conteudos/{conteudo}', [ConteudosController::class, 'show'])->name('conteudos.show');
Route::get('/conteudos/{conteudo}/edit', [ConteudosController::class, 'edit'])->name('conteudos.edit');
Route::post('/conteudos', [ConteudosController::class, 'store'])->name('conteudos.store');
Route::put('/conteudos/{conteudos}', [ConteudosController::class, 'update'])->name('conteudos.update');
Route::delete('/conteudos/{conteudos}', [ConteudosController::class, 'destroy'])->name('conteudos.destroy');


