<?php

use App\Modules\Assuntos\Controllers\AssuntoController;
use App\Modules\Autores\Controllers\AutorController;
use App\Modules\Livros\Controllers\LivroController;
use App\Modules\Relatorios\Controllers\RelatorioAutorLivroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Autores
Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::get('/autores/cadastro', [AutorController::class, 'create'])->name('autores.create');
Route::get('/autores/cadastro/{id}', [AutorController::class, 'edit'])->name('autores.edit');
Route::post('/autores/cadastro', [AutorController::class, 'store'])->name('autores.store');
Route::put('/autores/{id}', [AutorController::class, 'update'])->name('autores.update');
Route::delete('/autores/{id}', [AutorController::class, 'destroy'])->name('autores.delete');

// Assuntos
Route::get('/assuntos', [AssuntoController::class, 'index'])->name('assuntos.index');
Route::get('/assuntos/cadastro', [AssuntoController::class, 'create'])->name('assuntos.create');
Route::get('/assuntos/cadastro/{id}', [AssuntoController::class, 'edit'])->name('assuntos.edit');
Route::post('/assuntos/cadastro', [AssuntoController::class, 'store'])->name('assuntos.store');
Route::put('/assuntos/{id}', [AssuntoController::class, 'update'])->name('assuntos.update');
Route::delete('/assuntos/{id}', [AssuntoController::class, 'destroy'])->name('assuntos.delete');

//Relatórios
Route::prefix('relatorios')->group(function () {
    Route::get('/autores-livros', [RelatorioAutorLivroController::class, 'gerar'])->name('relatorio.autor_livros');
});

// Livros
Route::get('/livros', [LivroController::class, 'index'])->name('livros.index');
Route::get('/livros/cadastro', [LivroController::class, 'create'])->name('livros.create');
Route::get('/livros/cadastro/{id}', [LivroController::class, 'edit'])->name('livros.edit');
Route::post('/livros/cadastro', [LivroController::class, 'store'])->name('livros.store');
Route::put('/livros/{id}', [LivroController::class, 'update'])->name('livros.update');
Route::delete('/livros/{id}', [LivroController::class, 'destroy'])->name('livros.delete');