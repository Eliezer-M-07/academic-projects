<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/livro/cadastrar', [LivroController::class, 'form_cadastrar'])->name('livro.form_cadastro');

    Route::post('/livro/cadastrar', [LivroController::class, 'create'])->name('livro.cadastro');

    Route::get('/livro/editar/{livro}', [LivroController::class, 'form_editar'])->name('livro.form_editar');

    Route::put('/livro/editar/{livro}', [LivroController::class, 'editar'])->name('livro.editar');

    Route::delete('/livro/{livro}', [LivroController::class, 'deletar'])->name('livro.deletar');

    Route::get('/livro/{livro}', [LivroController::class, 'show'])->name('livro.show');

    Route::get('/usuario/livros', [LivroController::class, 'index'])->name('usuario.livros');

 
    Route::get('/usuario/perfil', [UsuarioController::class, 'perfil'])->name('usuario.perfil');

    Route::get('/usuario/editar', [UsuarioController::class, 'form_editar'])->name('usuario.form_editar');

    Route::put('/usuario/editar', [UsuarioController::class, 'editar'])->name('usuario.editar');


    Route::post('/usuario/logout', [AuthController::class, 'logout'])->name('usuario.logout');

    Route::delete('/usuario/deletar', [UsuarioController::class, 'deletar'])->name('usuario.deletar');
});

Route::middleware('guest')->group(function () {

    Route::get('/usuario/cadastro', [AuthController::class, 'form_cadastrar'])->name('usuario.form_cadastro');

    Route::post('/usuario/cadastro', [AuthController::class, 'create'])->name('usuario.cadastro');

    Route::get('/usuario/login', [AuthController::class, 'form_login'])->name('login');

    Route::post('/usuario/login', [AuthController::class, 'login'])->name('usuario.login');
});